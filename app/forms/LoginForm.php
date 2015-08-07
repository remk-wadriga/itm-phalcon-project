<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 04-08-2015
 * Time: 09:29 AM
 */

namespace forms;

use abstracts\FormAbstract;
use Phalcon\Exception;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\StringLength;

class LoginForm extends FormAbstract
{
    public $email;
    public $password;

    /**
     * login
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function login($data)
    {
        if(!is_array($data)){
            throw new Exception('Login data mas by an array');
        }

        $validation = new Validation();
        $validation->add('email', new Email([
            'message' => 'Invalid email',
            'required' => true
        ]))->add('password', new StringLength([
            'max' => 255,
            'min' => 4,
            'message' => 'The password must be at least 4 characters',
            'required' => true
        ]));

        $validation->validate($data);
        $this->addMessages($validation->getMessages());

        if(!empty($this->getMessages())){
            return false;
        }

        $this->setAttributes($data);

        return $this->user()->login($this->email, $this->password);
    }
}