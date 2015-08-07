<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 04-08-2015
 * Time: 12:47 PM
 */

namespace listeners;

use abstracts\ListenerAbstract;
use Phalcon\Http\Response;

class ControllersListener extends ListenerAbstract
{
    /**
     * beforeDispatchLoop
     * @param \Phalcon\Events\Event $event
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     * @return bool;
     */
    public function beforeDispatchLoop($event, $dispatcher)
    {
        return true;
    }

    /**
     * beforeDispatch
     * @param \Phalcon\Events\Event $event
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     * @return bool;
     */
    public function beforeDispatch($event, $dispatcher)
    {
        return true;
    }

    /**
     * beforeExecuteRoute
     * @param \Phalcon\Events\Event $event
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     * @return bool|Response
     * @throws \Phalcon\Exception
     */
    public function beforeExecuteRoute($event, $dispatcher)
    {
        $controller = $dispatcher->getActiveController();
        $result = $controller->beforeAction();

        if($result instanceof Response){
            return $result->send();
        }elseif($result === false){
            $exception = $controller->getException();
            if(!is_null($exception)){
                throw $exception;
            }
        }

        return true;
    }

    /**
     * afterExecuteRoute
     * @param \Phalcon\Events\Event $event
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     */
    public function afterExecuteRoute($event, $dispatcher)
    {

    }

    /**
     * beforeNotFoundAction
     * @param \Phalcon\Events\Event $event
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     * @return bool
     */
    public function beforeNotFoundAction($event, $dispatcher)
    {
        return true;
    }

    /**
     * beforeException
     * @param \Phalcon\Events\Event $event
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     * @return bool
     */
    public function beforeException($event, $dispatcher)
    {
        return true;
    }

    /**
     * afterDispatch
     * @param \Phalcon\Events\Event $event
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     */
    public function afterDispatch($event, $dispatcher)
    {

    }

    /**
     * afterDispatchLoop
     * @param \Phalcon\Events\Event $event
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     */
    public function afterDispatchLoop($event, $dispatcher)
    {

    }
}