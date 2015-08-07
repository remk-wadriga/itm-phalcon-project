<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 31-07-2015
 * Time: 13:57 PM
 */

namespace abstracts;

use Phalcon\Mvc\Model;
use Phalcon\Validation\Message\Group;
use Phalcon\Mvc\Model\Message;

abstract class ModelAbstract extends Model
{
    private $_isNew = false;

    public function update($data = null, $whiteList = null)
    {
        $this->_isNew = false;
        return parent::update($data, $whiteList);
    }

    public function save($data = null, $whiteList = null)
    {
        $this->_isNew = !isset($this->id);

        $data = $this->beforeSave($data);
        if(!is_array($data)){
            return false;
        }

        $result = parent::save($data, $whiteList);

        $this->afterSave($data);

        return $result;
    }

    public function create($data = null, $whiteList = null)
    {
        $this->_isNew = true;
    }

    public function beforeSave($data = null)
    {
        return $data;
    }

    public function afterSave($data = null)
    {

    }

    public function isNew()
    {
        return $this->_isNew;
    }

    public static function className()
    {
        return get_called_class();
    }

    /**
     * setAttributes
     * @param array $attributes
     */
    protected function setAttributes(array $attributes)
    {
        foreach($attributes as $name => $value){
            $this->setAttribute($name, $value);
        }
    }

    /**
     * setAttribute
     * @param string $name
     * @param mixed $value
     */
    protected function setAttribute($name, $value)
    {
        $setterMethod = 'set'.ucfirst($name);
        if(method_exists($this, $setterMethod)){
            $this->$setterMethod($value);
        }elseif(property_exists($this, $name)){
            $this->$name = $value;
        }
    }

    protected function addMessages(Group $messages)
    {
        foreach($messages as $message){
            $this->appendMessage(new Message($message->getMessage(), $message->getField(), $message->getType()));
        }
    }

    /**
     * getTimeService
     * @return \components\TimeService
     */
    protected function timeService()
    {
        return $this->getService('timeService');
    }

    /**
     * getService
     * @param string $key
     * @return mixed|object
     */
    protected function getService($key)
    {
        return $this->getDI()->get($key);
    }
}