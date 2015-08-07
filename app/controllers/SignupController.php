<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 31-07-2015
 * Time: 13:44 PM
 */

namespace controllers;

use abstracts\ControllerAbstract;
use models\User;

class SignupController extends ControllerAbstract
{
    public function indexAction()
    {

    }

    public function registerAction()
    {
        $user = new User();

        $success = $user->save($this->request->getPost());
        if ($success) {
            return $this->redirect('signin/index');
        } else {
            echo 'Sorry, the following problems were generated: ';
            foreach ($user->getMessages() as $message) {
                echo $message->getMessage(), '<br/>';
            }
        }

        $this->view->disable();
    }
}