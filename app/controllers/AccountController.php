<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 04-08-2015
 * Time: 11:17 AM
 */

namespace controllers;

use abstracts\ControllerAbstract;

class AccountController extends ControllerAbstract
{
    public function beforeAction()
    {
        if(!$this->getUser()->getIsLogged()){
            return $this->redirect('signin');
        }

        return parent::beforeAction();
    }

    public function indexAction()
    {

    }
}