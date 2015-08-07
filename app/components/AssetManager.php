<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 04-08-2015
 * Time: 14:50 PM
 */

namespace components;

use abstracts\ServiceAbstract;
use abstracts\AssetAbstract;
use interfaces\AssetManagerInterface;

class AssetManager extends ServiceAbstract implements AssetManagerInterface
{
    const MIMETYPE_STYLESHEET = 'stylesheet';
    const MIMETYPE_JAVASCRIPT = 'text/javascript';
    const MIMETYPE_FONOBJECT = 'application/vnd.ms-fontobject';
    const MIMETYPE_SVG_XML = 'image/svg+xml';
    const MIMETYPE_TTF = 'application/x-font-ttf';
    const MIMETYPE_WOOF = 'application/x-font-woff';
    const MIMETYPE_OCTET_STREAM = 'application/octet-stream';

    /**
     * @var AssetAbstract[]
     */
    public $collections = [];
    public $basePath;
    public $cssPath;
    public $jsPath;
    public $fontsPath;
    public $assetsNamespace;
    public $defaultMimeType = 'stylesheet';

    protected $cssPattern = '<link rel="%s" type="text/css" href="%s">';
    protected $jsPattern = '<script type="%s" src="%s"></script>';
    protected $fontPattern = '<link rel="%s" type="text/css" href="%s">';
    protected $scriptsPattern = '<script type="text/javascript">jQuery(function($){%s});</script>';
    protected $displayAfterRenderPattern = '<script type="text/javascript">window.onload=function(){%s}</script>';
    protected $css = [];
    protected $js = [];
    protected $fonts = [];
    protected $scripts = [];

    protected $_displayedScc = [];
    protected $_displayedJs = [];
    protected $_displayedFonts = [];
    protected $_displayedScripts = [];

    private static $_mimeTypes = [
        self::MIMETYPE_STYLESHEET => '.css',
        self::MIMETYPE_JAVASCRIPT => '.js',
        self::MIMETYPE_FONOBJECT => '.eot',
        self::MIMETYPE_SVG_XML => '.svg',
        self::MIMETYPE_TTF => '.ttf',
        self::MIMETYPE_WOOF => '.woff',
        self::MIMETYPE_OCTET_STREAM => '.woff2',
    ];

    public function init()
    {
        $this->addCollections($this->collections);
    }

    public function addCss($css)
    {
        $this->css[] = $css;
    }

    public function addJs($js)
    {
        $this->js[] = $js;
    }

    public function addFont($font)
    {
        $this->fonts[] = $font;
    }

    public function assScript($script)
    {
        $this->scripts[] = $script;
    }

    /**
     * displayScc
     * @param string $collection
     */
    public function displayScc($collection = null)
    {
        $this->displayAssets($collection, 'css');
    }

    /**
     * displayJs
     * @param string $collection
     */
    public function displayJs($collection = null)
    {
        $this->displayAssets($collection, 'js');
    }

    /**
     * displayFonts
     * @param string $collection
     */
    public function displayFonts($collection = null)
    {
        $this->displayAssets($collection, 'fonts');
    }

    /**
     * displayFonts
     * @param string $collection
     */
    public function displayScripts($collection = null)
    {
        $this->displayAssets($collection, 'scripts');
    }

    /**
     * getCollection
     * @param string $collection
     * @return \abstracts\AssetAbstract|null
     */
    public function getCollection($collection)
    {
        return isset($this->collections[$collection]) ? $this->collections[$collection] : null;
    }

    /**
     * addCollections
     * @param array $collections
     * @param \abstracts\AssetAbstract $dependent
     */
    public function addCollections(array $collections, $dependent = null)
    {
        foreach($collections as $index => $collection){
            $params = [];
            if(is_array($collection)){
                $params = $collection;
                $collection = $index;
            }

            if(strpos($collection, '\\') === false){
                $collectionClass = $this->assetsNamespace . '\\' . ucfirst($collection) . 'Asset';
                $key = $collection;
            }else{
                $collectionClass = $collection;
                if(is_string($index)){
                    $key = $index;
                }else{
                    $classNameParts = explode('\\', $collection);
                    $className = end($classNameParts);
                    $key = lcfirst($className);
                }
            }

            if(!class_exists($collectionClass)){
                continue;
            }

            if(!isset($params['priority'])){
                $params['priority'] = AssetAbstract::PRIORITY_PAGE;
            }
            if(!isset($params['id'])){
                $params['id'] = $key;
            }

            $newCollection = new $collectionClass($params);

            if($dependent !== null){
                $newCollection->cssPos = $dependent->cssPos;
                $newCollection->jsPos = $dependent->jsPos;
                $newCollection->fontsPos = $dependent->fontsPos;
            }

            $newCollection->css = $this->getStyles($newCollection);
            $newCollection->js = $this->getScripts($newCollection);
            $newCollection->fonts = $this->getFonts($newCollection);

            if(isset($newCollection->depending)){
                $depending = [];
                foreach($newCollection->depending as $dependingName){
                    if(isset($this->collections[$dependingName])){
                        $depending[$dependingName] = $this->collections[$dependingName];
                    }else{
                        $depending[] = $dependingName;
                    }
                }

                $this->addCollections(array_reverse($depending), $newCollection);
            }

            if($dependent !== null){
                $dependent->css = array_merge($newCollection->css, $dependent->css);
                $dependent->js = array_merge($newCollection->js, $dependent->js);
                $dependent->fonts = array_merge($newCollection->fonts, $dependent->fonts);
                $dependent->scripts = array_merge($newCollection->scripts, $dependent->scripts);
            }

            $this->collections[$key] = $newCollection;
        }
    }

    private function getStyles(AssetAbstract $collection)
    {
        return $this->getAsset($collection, 'css');
    }

    private function getScripts(AssetAbstract $collection)
    {
        return $this->getAsset($collection, 'js', '.js');
    }

    private function getFonts(AssetAbstract $collection)
    {
        return $this->getAsset($collection, 'fonts');
    }

    private function getAsset(AssetAbstract $collection, $assetName, $ext = '.css')
    {
        switch($assetName){
            case 'js':
                $pos = $collection->jsPos;
                break;
            case 'fonts':
                $pos = $collection->fontsPos;
                break;
            case 'css':
                $pos = $collection->cssPos;
                break;
            default:
                $pos = null;
                break;
        }

        $assetsArr = [];
        $path = isset($collection->basePath) ? $collection->basePath : $this->basePath;

        if(!empty($collection->$assetName)){
            $pathName = $assetName . 'Path';
            $assetPath = isset($collection->$pathName) ? $collection->$pathName : $this->$pathName;
            $assetPath = str_replace(['//', '\\\\', DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR], '/', $path . $assetPath . '/');
            foreach($collection->$assetName as $asset){
                $assetsArr[] = [
                    'file' => $assetPath . $asset . $ext,
                    'pos' => $pos,
                ];
            }
        }

        return $assetsArr;
    }

    private function displayAssets($collection, $assetName)
    {
        switch($assetName){
            case 'js':
                $displayedArr = &$this->_displayedJs;
                $pattern = $this->jsPattern;
                break;
            case 'fonts':
                $displayedArr = &$this->_displayedFonts;
                $pattern = $this->fontPattern;
                break;
            case 'scripts':
                $displayedArr = &$this->_displayedScripts;
                $pattern = $this->scriptsPattern;
                break;
            default:
                $displayedArr = &$this->_displayedScc;
                $pattern = $this->cssPattern;
                break;
        }

        $i = 0;

        foreach($this->getAssetsArray($collection, $assetName) as $asset){
            if(is_array($asset)){
                $pos = $asset['pos'];
                $file = $asset['file'];
            }else{
                $pos = null;
                $file = $asset;
            }

            if(in_array($file, $displayedArr)){
                continue;
            }
            $displayedArr[] = $file;

            if($pos !== null && $pos !== AssetAbstract::POS_CONTENT && $assetName !== 'scripts'){
                $displayedString = '';
                $elementName = 'new_page_elem_' . $assetName . $i++;

                switch($pos){
                    case AssetAbstract::POS_TOP:
                        $identifier = 'document.getElementsByTagName("head")[0]';
                        break;
                    default:
                        $identifier = 'document.getElementsByTagName("body")[0]';
                        break;
                }

                switch($assetName){
                    case 'js':
                        $displayedString .= ';var '. $elementName . '=document.createElement("script");';
                        $displayedString .= $elementName . '.setAttribute("type","text/javascript");';
                        $displayedString .= $elementName . '.setAttribute("src", "' . $file . '");';
                        $displayedString .= $identifier . '.appendChild(' . $elementName . ');';
                        break;
                    default:
                        $displayedString .= ';var '. $elementName . '=document.createElement("link");';
                        $displayedString .= $elementName . '.setAttribute("rel", "stylesheet");';
                        $displayedString .= $elementName . '.setAttribute("type", "text/css");';
                        $displayedString .= $elementName . '.setAttribute("href", "' . $file . '");';
                        $displayedString .= $identifier . '.appendChild(' . $elementName . ');';
                        break;
                }

                $displayedString = sprintf($this->displayAfterRenderPattern, $displayedString);
            }else{
                if($assetName !== 'scripts'){
                    $displayedString = sprintf($pattern, $this->getMimeType($file), $file);
                }else{
                    $displayedString = sprintf($pattern, $file);
                }
            }

            echo $displayedString;
        }
    }

    private function getAssetsArray($collection, $assetName)
    {
        $assetsArray = [];
        if($collection !== null){
            $collection = $this->getCollection($collection);
            if($collection !== null){
                $assetsArray = $collection->$assetName;
            }
            foreach($this->collections as $collection){
                if($collection->priority == AssetAbstract::PRIORITY_MAIN){
                    $assetsArray = array_merge($assetsArray, $collection->$assetName);
                }
            }
        }else{
            foreach($this->collections as $collection){
                $assetsArray = array_merge($assetsArray, $collection->$assetName);
            }
        }

        return array_merge($assetsArray, $this->$assetName);
    }

    private function getMimeType($link)
    {
        $mime = null;

        foreach(self::$_mimeTypes as $mimeType => $prefixes){
            if(!is_array($prefixes)){
                $prefixes = [$prefixes];
            }

            foreach($prefixes as $prefix){
                if(strpos($link, $prefix)){
                    $mime = $mimeType;
                    break;
                }
            }

            if($mime !== null){
                break;
            }
        }

        return $mime !== null ? $mime : $this->defaultMimeType;
    }
}