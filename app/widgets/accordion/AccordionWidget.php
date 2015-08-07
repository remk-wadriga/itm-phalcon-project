<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 05-08-2015
 * Time: 14:16 PM
 */

namespace widgets\accordion;

use abstracts\WidgetAbstract;
use abstracts\AssetAbstract;
use widgets\accordion\assets\AccordionAsset;

class AccordionWidget extends WidgetAbstract
{
    const TYPE_MAIN = 0;

    public $modelClass;
    public $methodName;

    protected $_items;

    public function init()
    {
        echo $this->render('template.php', [
            'content' => $this->renderItems()
        ]);
    }

    /**
     * getAssets
     * @return AssetAbstract[]
     */
    public function getAssets()
    {
        return [
            'accordionAsset' => AccordionAsset::className(),
        ];
    }

    public function getItems()
    {
        if($this->_items !== null){
            return $this->_items;
        }

        $class = $this->modelClass;
        $method = $this->methodName;

        $this->_items = [];

        if(class_exists($class) && method_exists($class, $method)){
            $this->_items = $class::$method();
        }

        return $this->_items;
    }

    protected function renderItems(array $items = null)
    {
        if($items === null){
            $items = $this->getItems();
        }
        $string = '';

        foreach($items as $item){
            $params = ['item' => $item];
            if(!empty($item['children'])){
                $params['children'] = $this->renderItems($item['children']);
            }
            $string .= $this->render($params);
        }

        return $string;
    }
}