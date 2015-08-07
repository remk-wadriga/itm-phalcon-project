<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 05-08-2015
 * Time: 14:13 PM
 */

namespace abstracts;

use interfaces\AssetManagerInterface;

abstract class WidgetAbstract
{
    public $basePath = APP_PATH . '/app/widgets';
    public $templatesView = '/views';
    public $defaultView = 'index.php';

    private $_widgetName;

    public function __construct($params = [])
    {
        foreach($params as $name => $value){
            if(property_exists($this, $name)){
                $this->$name = $value;
            }
        }
    }

    public static function run($params = [])
    {
        $class = get_called_class();
        return new $class($params);
    }

    /**
     * getAssets
     * @return AssetAbstract[]
     */
    public function getAssets()
    {
        return [];
    }

    abstract public function init();

    /**
     * render
     * @param string $view
     * @param array $prams
     * @return string
     */
    public function render($view = null, $prams = [])
    {
        if(is_array($view)){
            $prams = $view;
            $view = null;
        }

        $view = $this->getViewFile($view);
        if(!file_exists($view)){
            return null;
        }

        ob_start();
            foreach($prams as $name => $value){
                $$name = $value;
            }
            include($view);

            $viewString = ob_get_contents();
        ob_end_clean();

        return $viewString;
    }

    public function getViewFile($view)
    {
        if($view === null){
            $view = $this->defaultView;
        }

        $view = $this->basePath . DIRECTORY_SEPARATOR . $this->getWidgetName() . $this->templatesView . DIRECTORY_SEPARATOR . $view;
        return $this->getCorrectPath($view);
    }

    private function getWidgetName()
    {
        if($this->_widgetName !== null){
            return $this->_widgetName;
        }

        $className = get_class($this);
        $classParts = explode('\\', $className);
        array_shift($classParts);
        array_pop($classParts);
        return $this->_widgetName = implode('/', $classParts);
    }

    private function getCorrectPath($path)
    {
        return str_replace(['/', '\\', '//', '\\\\'], DIRECTORY_SEPARATOR, $path);
    }
}