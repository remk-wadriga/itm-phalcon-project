<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 06-08-2015
 * Time: 17:03 PM
 */

namespace components;

use abstracts\ServiceAbstract;
use Phalcon\Di;

class WidgetManager extends ServiceAbstract
{
    public $widgetsNameSpace;
    public $widgets = [];

    /**
     * @var \Phalcon\Di
     */
    private $_di;

    public function setDi(Di $di)
    {
        $this->_di = $di;
    }

    /**
     * getAssetManager
     * @return \interfaces\AssetManagerInterface
     */
    public function getAssetManager()
    {
        return $this->_di->get('assetManager');
    }

    public function run($widget, $params = [])
    {
        $widgetClass = $this->getWidgetClass($widget);
        if($widgetClass !== null){
            if(isset($this->widgets[$widget])){
                $params = array_merge($params, $this->widgets[$widget]);
            }

            $widget = $widgetClass::run($params);

            $collections = $widget->getAssets();

            $assetManager = $this->getAssetManager();
            $assetManager->addCollections($collections);
            $assetManager->displayScc();

            $widget->init();
        }
    }

    /**
     * getWidgetClass
     * @param $widget
     * @return null|string
     */
    protected function getWidgetClass($widget)
    {
        $class = $this->widgetsNameSpace . '\\' . $widget . '\\' . ucfirst($widget) . 'Widget';
        return class_exists($class) ? $class : null;
    }
}