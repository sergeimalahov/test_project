<?php

namespace app\models;

use yii\mongodb\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class User
 *
 * @property string $_id;
 * @property string $email;
 * @property string $password_hash;
 * @property string $auth_token
 * @property string $title;
 * @property string $bio;
 * @property string $avatar_url;
 *
 * @package app\models
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @var
     */
    public $avatar;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $validate_password;

    /**
     * @return string
     */
    public static function collectionName()
    {
        return 'user';
    }

    /**
     * @return array list of attribute names.
     */
    public function attributes()
    {
        return ['_id', 'email', 'password_hash', 'auth_token', 'title', 'bio', 'avatar_url'];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['email', 'password', 'validate_password'], 'required', 'on' => 'insert'],
            ['password', 'compare', 'compareAttribute' => 'validate_password', 'on' => 'insert'],
            ['email', 'email'],
            ['email', 'unique'],
            [['title', 'bio', 'password', 'validate_password'], 'string'],
            ['bio', 'string', 'max' => 200]
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if (!empty($this->password) && !empty($this->validate_password)) {
            $this->password_hash = \Yii::$app->security->generatePasswordHash($this->password);
            $this->auth_token = \Yii::$app->security->generateRandomString();
        }

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()->where(['auth_token' => $token])->one();
    }

    /**
     * @param $email
     * @return User|null|ActiveRecord
     */
    public static function findByEmail($email)
    {
        return static::find()->where(['email' => $email])->one();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_token;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_token === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
