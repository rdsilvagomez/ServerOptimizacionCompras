<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Usuarios".
 *
 * @property integer $id
 * @property string  $firstname
 * @property string  $lastname
 * @property string  $username
 * @property string  $password
 */
class Usuarios extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
               return [
                   [['firstname', 'lastname', 'username', 'password'], 'string'],
                   [['idProveedor'], 'integer'], 
                   [['idProveedor'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedores::className(), 'targetAttribute' => ['idProveedor' => 'id']], 
               ];
           }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'username' => 'Username',
            'password' => 'Password',
            'idProveedor'=>'idProveedor'
        ];
    }

  public function getIdProveedor() 
           { 
               return $this->hasOne(Proveedores::className(), ['id' => 'idProveedor']); 
           } 
    public static function findIdentity($id){
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null){
        throw new NotSupportedException();//I don't implement this method because I don't have any access token column in my database
    }

    public function getId(){
        return $this->id;
    }

    public function getAuthKey(){
    ///    return $this->authKey;//Here I return a value of my authKey column
    }

    public function validateAuthKey($authKey){
       // return $this->authKey === $authKey;
    }
    public static function findByUsername($username){
        return self::findOne(['username'=>$username]);
    }

    public function validatePassword($password){
        return $this->password === $password;
    }

}
