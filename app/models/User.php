<?php

namespace models;

use abstracts\ModelAbstract;
use Phalcon\Mvc\Model\Validator\Email;
use Phalcon\Mvc\Model\Validator\StringLength;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation;
use interfaces\UserIdentityInterface;

/**
 * Class User
 * @package models
 */
class User extends ModelAbstract implements UserIdentityInterface
{
    const PASSWORD_HASH_SALT = 'Uds877SDd099SDwFr345D';
    const ROLE_USER = 'ROLE_USER';
    const ROLE_MODERATOR = 'ROLE_MODERATOR';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const STATUS_NEW = 'STATUS_NEW';
    const STATUS_ACTIVE = 'STATUS_ACTIVE';
    const STATUS_BANNED = 'STATUS_BANNED';
    const STATUS_FROZEN = 'STATUS_FROZEN';
    const STATUS_DELETED = 'STATUS_DELETED';

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $password_hash;

    /**
     *
     * @var string
     */
    public $first_name;

    /**
     *
     * @var string
     */
    public $last_name;

    /**
     *
     * @var string
     */
    public $phone;

    /**
     *
     * @var string
     */
    public $reg_date;

    /**
     *
     * @var string
     */
    public $last_visit_date;

    /**
     *
     * @var string
     */
    public $role;

    /**
     *
     * @var string
     */
    public $status;

    /**
     *
     * @var string
     */
    public $info;

    /**
     *
     * @var integer
     */
    public $rating;


    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $retype_password;

    /**
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        // Confirmation
        $this->validate(new Email([
            'field'    => 'email',
            'required' => true,
        ]))->validate(new Uniqueness([
            'field'    => 'email',
        ]))->validate(new StringLength([
            'field' => 'password',
            'max' => 255,
            'required' => true,
        ]))->validate(new StringLength([
            'field' => 'first_name',
            'max' => 50,
        ]))->validate(new StringLength([
            'field' => 'last_name',
            'max' => 50,
        ]))->validate(new StringLength([
            'field' => 'phone',
            'max' => 36,
        ]));

        if ($this->validationHasFailed() == true) {
            return false;
        }

        return true;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'user';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return User[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return User
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


    // Events

    public function beforeSave($data = null)
    {
        if(!$this->isNew()){
            return true;
        }

        $validation = new Validation();
        $validation->add('password', new Confirmation(array(
            'message' => 'Password doesn\'t match confirmation',
            'with' => 'retype_password'
        )));

        $validation->validate($data);
        $this->addMessages($validation->getMessages());

        if(!empty($this->getMessages())){
            return false;
        }

        if(!isset($data['reg_date'])){
            $data['reg_date'] = $this->timeService()->currentDateTime();
        }
        if(!isset($data['role'])){
            $data['role'] = self::ROLE_USER;
        }
        if(!isset($data['status'])){
            $data['status'] = self::STATUS_NEW;
        }
        if(!isset($data['rating'])){
            $data['rating'] = (int)$this->rating;
        }
        if(isset($data['password'])){
            $data['password_hash'] = $this->createPasswordHash($data['password'], $data['reg_date'], $data['email']);
        }

        return $data;
    }

    // END Events



    // Getters and setters

    // END Getters and setters
    
    
    // Public functions

    public function getName()
    {
        $name = $this->first_name;
        if(!empty($this->last_name)){
            $name .= !empty($name) ? ' '.$this->last_name : $this->last_name;
        }

        return !empty($name) ? $name : $this->email;
    }

    // END Public functions


    // Protected functions

    /**
     * createPasswordHash
     * @param string $password
     * @param string $regDate
     * @param string $email
     * @return string
     */
    protected function createPasswordHash($password = null, $regDate = null, $email = null)
    {
        if($password === null){
            $password = $this->password;
        }
        if($regDate === null){
            $regDate = $this->reg_date;
        }
        if($email === null){
            $email = $this->email;
        }

        return hash('md5', $password.self::PASSWORD_HASH_SALT.$regDate.$email);
    }
    
    // END Protected functions



    // Implementing UserIdentityInterface

    /**
     * getByID
     * @param int $id
     * @return User
     */
    public static function getByID($id)
    {
        return self::findFirst($id);
    }

    /**
     * getByUserName
     * @param string $userName
     * @return User
     */
    public static function getByUserName($userName)
    {
        return self::findFirst(['email' => $userName]);
    }

    /**
     * getID
     * @return int
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * validatePassword
     * @param string $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return $this->password_hash === $this->createPasswordHash($password);
    }

    /**
     * setLoginTime
     */
    public function setLoginTime()
    {
        $this->last_visit_date = $this->timeService()->currentDateTime();
        $this->update();
    }
    // END Implementing UserIdentityInterface
}
