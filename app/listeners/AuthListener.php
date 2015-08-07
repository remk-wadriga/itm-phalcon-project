<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 04-08-2015
 * Time: 10:10 AM
 */

namespace listeners;

use abstracts\ListenerAbstract;

class AuthListener extends ListenerAbstract
{
    /**
     * beforeLogin
     * @param \Phalcon\Events\Event $event
     * @param \components\UserService $userService
     * @param array $data
     */
    public function beforeLogin($event, $userService, $data)
    {

    }

    /**
     * loginFailed
     * @param \Phalcon\Events\Event $event
     * @param \components\UserService $userService
     * @param array $data
     */
    public function loginFailed($event, $userService, $data)
    {

    }

    /**
     * afterLogin
     * @param \Phalcon\Events\Event $event
     * @param \components\UserService $userService
     * @param \interfaces\UserIdentityInterface $identity
     */
    public function afterLogin($event, $userService, $identity)
    {
        $identity->setLoginTime();
    }
}