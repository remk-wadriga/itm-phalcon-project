<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 04-08-2015
 * Time: 09:26 AM
 */

namespace abstracts;

use Phalcon\Mvc\Model;
use Phalcon\Validation\Message\Group;
use Phalcon\Mvc\Model\Message;

abstract class FormAbstract extends Model
{
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

    /**
     * addMessages
     * @param Group $messages
     */
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
     * user
     * @return \components\UserService
     */
    protected function user()
    {
        return $this->getService('user');
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