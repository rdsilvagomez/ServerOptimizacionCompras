<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Customer".
 *
 * @property integer $id
 * @property string $SocialId
 * @property string $name
 * @property string $LastName
 * @property string $FullName
 * @property string $Credit
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SocialId', 'name', 'LastName', 'FullName'], 'string'],
            [['Credit'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'SocialId' => 'Social ID',
            'name' => 'Name',
            'LastName' => 'Last Name',
            'FullName' => 'Full Name',
            'Credit' => 'Credit',
        ];
    }
}
