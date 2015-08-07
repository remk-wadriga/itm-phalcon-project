<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 03-08-2015
 * Time: 16:09 PM
 */

namespace controllers;

use abstracts\ControllerAbstract;
use forms\LoginForm;

class SigninController extends ControllerAbstract
{
    public function indexAction()
    {

    }

    public function loginAction()
    {
        $form = new LoginForm();
        if($form->login($this->post())){
            return $this->redirect('account/index');
        }else{
            echo 'Sorry, the following problems were generated: ';
            foreach ($form->getMessages() as $message) {
                echo $message->getMessage(), '<br/>';
            }
        }
    }
}