<?php

namespace models;

use abstracts\ModelAbstract;

/**
 * Class LeftMenu
 * @package models
 *
 * @attribute integer $parentId
 */
class LeftMenu extends ModelAbstract
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $parent_id;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var string
     */
    public $link;

    /**
     *
     * @var integer
     */
    public $position;

    /**
     *
     * @var string
     */
    public $style;

    /**
     *
     * @var string
     */
    public $icon;

    /**
     *
     * @var integer
     */
    public $type;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'left_menu';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return LeftMenu[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return LeftMenu
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


    // Getters and setters

    /**
     * setParentId
     * @param $val
     * @return $this
     */
    public function setParentId($val)
    {
        $this->parent_id = $val;
        return $this;
    }

    public function getParentId()
    {
        return $this->parent_id;
    }

    // Getters and setters


    // Implements WidgetFunctionInterface

    /**
     * getItemsArray
     * @return array
     */
    public static function getItemsArray($parent = 0)
    {
        $items = [];
        $list = self::query()
            ->where('parent_id=:parent:')
            ->bind(['parent' => $parent])
            ->orderBy('position')
            ->execute()
            ->toArray();

        foreach($list as $item){
            $item['children'] = self::getItemsArray($item['id']);
            $items[] = $item;
        }

        return $items;
    }

    // END Implements WidgetFunctionInterface

}
