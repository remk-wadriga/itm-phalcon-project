<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 03-08-2015
 * Time: 16:50 PM
 */

namespace components;

use abstracts\ServiceAbstract;
use interfaces\UserIdentityInterface;
use Phalcon\Exception;
use Phalcon\Session\Adapter\Files AS SessionAdapter;
use Phalcon\Events\EventsAwareInterface;
use Phalcon\Events\ManagerInterface;
use Phalcon\Di;

class UserService extends ServiceAbstract implements EventsAwareInterface
{
    /**
     * @var \interfaces\UserIdentityInterface
     */
    private $_identity;

    /**
     * @var integer
     */
    private $_id;

    /**
     * @var ManagerInterface
     */
    private $_eventsManager;

    /**
     * @var \Phalcon\Di
     */
    private $_di;

    public $identityClass;
    public $sessionKey = 'USER_IDENTITY';

    public function getName()
    {
        return $this->getIdentity()->getName();
    }

    public function login($userName, $password)
    {
        $data = [
            'userName' => $userName,
            'password' => $password
        ];
        $eventManager = $this->getEventsManager();
        // Create event "beforeLogin" for event manager
        $eventManager->fire('user:beforeLogin', $this, $data);

        if(empty($userName) || empty($password)){
            $data['error'] = 'Useraname and password required';

            // Create event "loginFailed" for event manager
            $eventManager->fire('user:loginFailed', $this, $data);
            throw new Exception($data['error']);
        }

        // Clear user session
        $this->logout();
        // Get identity class
        $identityClass = $this->getIdentityClass();
        // Find the user identity object
        $identityObject = $identityClass::getByUserName($userName);

        // Check the identity object and password
        if(!empty($identityObject) && $identityObject->validatePassword($password)){
            // Add user ID in session
            $this->getSession()->set($this->sessionKey, $identityObject->getID());
            $this->_identity = $identityObject;

            // Create event "afterLogin" for event manager
            $eventManager->fire('user:afterLogin', $this, $identityObject);
            return true;
        }else{
            $data['error'] = 'UserName or password is incorrect';

            // Create event "loginFailed" for event manager
            $eventManager->fire('user:loginFailed', $this, $data);
            return false;
        }
    }

    public function logout()
    {
        $this->getSession()->remove($this->sessionKey);
    }

    public function setDi(Di $di)
    {
        $this->_di = $di;
    }

    /**
     * getSession
     * @return SessionAdapter
     */
    public function getSession()
    {
        return $this->_di->get('session');
    }

    /**
     * getIdentity
     * @return UserIdentityInterface
     * @throws Exception
     */
    public function getIdentity()
    {
        if($this->_identity !== null){
            return $this->_identity;
        }

        $id = $this->getID();
        if($id > 0){
            $identityClass = $this->getIdentityClass();
            $identityObject = $identityClass::getByID($this->getID());
        }else{
            throw new Exception('User is not logged');
        }

        return $this->_identity = $identityObject;
    }

    /**
     * getID
     * @return int
     */
    public function getID()
    {
        if($this->_id !== null){
            return $this->_id;
        }

        return $this->_id = $this->getSession()->get($this->sessionKey, 0);
    }

    /**
     * getIsLogged
     * @return bool
     */
    public function getIsLogged()
    {
        return $this->getID() > 0;
    }

    /**
     * getIdentityClass
     * @return UserIdentityInterface
     * @throws Exception
     */
    protected function getIdentityClass()
    {
        $identityClass = $this->identityClass;
        if(!class_exists($identityClass)){
            throw new Exception('Incorrect identity class');
        }

        return $identityClass;
    }


    // Implements EventsAwareInterface

    /**
     * setEventsManager
     * @param ManagerInterface $eventsManager
     */
    public function setEventsManager(ManagerInterface $eventsManager)
    {
        $this->_eventsManager = $eventsManager;
    }

    /**
     * getEventsManager
     * @return ManagerInterface
     */
    public function getEventsManager()
    {
        return $this->_eventsManager;
    }

    // END Implements EventsAwareInterface
}