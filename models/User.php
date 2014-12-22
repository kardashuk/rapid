<?php

namespace app\models;
use yii\mongodb\Query;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $_id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $create_date;

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $data = (new Query)->from('users')->where(['_id' => $id])->one();
        return new self($data);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $data =  (new Query)->from('users')->where(['accessToken' => $token])->one();
        return new self($data);
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $data = (new Query)->from('users')->where(['username' => $username])->one();
        return new self($data);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return crypt($password, $this->password) === $this->password;
    }
}
