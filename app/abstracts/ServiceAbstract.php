<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 03-08-2015
 * Time: 13:16 PM
 */

namespace abstracts;


abstract class ServiceAbstract
{
    public function __construct($params = [])
    {
        $this->setParams($params);
        $this->init();
    }

    public function __get($name)
    {
        return $this->getAttribute($name);
    }

    public function __set($name, $value)
    {
        $this->setAttribute($name, $value);
    }

    public function init()
    {

    }

    protected function getAttribute($name)
    {
        if(property_exists($this, $name)){
            return $this->$name;
        }

        $methodGetter = 'get'.ucfirst($name);
        if(method_exists($this, $methodGetter)){
            return $this->$methodGetter();
        }

        return null;
    }

    protected function setAttribute($name, $value)
    {
        if(property_exists($this, $name)){
            $this->$name = $value;
        }

        $methodSetter = 'set'.ucfirst($name);
        if(method_exists($this, $methodSetter)){
            $this->$methodSetter($value);
        }
    }

    protected function setParams(array $params)
    {
        foreach($params as $name => $value){
            $this->setAttribute($name, $value);
        }
    }
}