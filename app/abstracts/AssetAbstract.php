<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 04-08-2015
 * Time: 14:51 PM
 */

namespace abstracts;


abstract class AssetAbstract
{
    const PRIORITY_MAIN = 1;
    const PRIORITY_PAGE = 2;
    const POS_TOP = 1;
    const POS_CONTENT = 2;
    const POS_BOTTOM = 3;

    public $id;
    public $js = [];
    public $css = [];
    public $fonts = [];
    public $scripts = [];
    public $depending = [];
    public $basePath;
    public $cssPath;
    public $jsPath;
    public $fontsPath;
    public $priority;
    public $cssPos;
    public $jsPos;
    public $fontsPos;

    public function __construct($params = [])
    {
        foreach($params as $name => $value){
            if(property_exists($this, $name)){
                $this->$name = $value;
            }
        }

        $this->init();
    }

    public function init()
    {

    }

    public static function className()
    {
        return get_called_class();
    }
}