<?php
/**
 * Created by Rem.
 * Author: Dmitry Kushneriv
 * Email: remkwadriga@yandex.ua
 * Date: 03-08-2015
 * Time: 17:01 PM
 */

namespace interfaces;


interface UserIdentityInterface
{
    /**
     * getByID
     * @param integer $id
     * @return UserIdentityInterface
     */
    public static function getByID($id);

    /**
     * getByUserName
     * @param string $userName
     * @return UserIdentityInterface
     */
    public static function getByUserName($userName);

    /**
     * getID
     * @return integer
     */
    public function getID();

    /**
     * getName
     * @return string
     */
    public function getName();

    /**
     * validatePassword
     * @param string $password
     * @return bool
     */
    public function validatePassword($password);

    /**
     * setLoginTime
     */
    public function setLoginTime();
}