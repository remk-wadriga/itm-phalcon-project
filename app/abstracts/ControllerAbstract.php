<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 03-08-2015
 * Time: 12:27 PM
 */

namespace abstracts;

use Phalcon\Exception;
use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
use Phalcon\Mvc\Url;
use Phalcon\Http\Request;

/**
 * Class ControllerAbstract
 * @package abstracts
 *
 * Components
 *
 */
abstract class ControllerAbstract extends Controller
{
    private $_exception;

    public function beforeAction()
    {
        return true;
    }

    public function render($view = null, $params = [])
    {
        if(is_array($view)){
            $params = $view;
            $view = null;
        }

        foreach($params as $name => $value){
            $this->view->setVar($name, $value);
        }
    }

    public function redirect($url = null, $externalRedirect = false, $statusCode = 302)
    {
        $response = new Response();
        return $response->redirect($this->createUrl($url), $externalRedirect, $statusCode);
    }

    public function createUrl($uri = null, $args = null, $local = null, $baseUri = null)
    {
        return $this->getUrl()->get($uri, $args, $local, $baseUri);
    }

    /**
     * getException
     * @return Exception|null
     */
    public function getException()
    {
        return $this->_exception;
    }

    protected function exception($message, $code = 500)
    {
        $this->_exception = new Exception($message, $code);
        return false;
    }

    /**
     * getUrl
     * @return Url
     */
    protected function getUrl()
    {
        return $this->getDI()->get('url');
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
     * getUser
     * @return \components\UserService;
     */
    protected function getUser()
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

    /**
     * post
     * @param string $name
     * @param mixed $defaultVal
     * @return mixed|void
     */
    public function post($name = null, $defaultVal = null)
    {
        $request = new Request();
        return $request->getPost($name, $defaultVal);
    }
}