<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 04-08-2015
 * Time: 10:11 AM
 */

namespace abstracts;

use Phalcon\Di\FactoryDefault;

abstract class ListenerAbstract
{
    /**
     * @var \Phalcon\Di\FactoryDefault
     */
    protected $_di;

    public function __construct($di = null)
    {
        if(!is_null($di) && $di instanceof FactoryDefault){
            $this->_di = $di;
        }
    }

    /**
     * getDi
     * @return FactoryDefault
     */
    protected function getDi()
    {
        return $this->_di;
    }
}