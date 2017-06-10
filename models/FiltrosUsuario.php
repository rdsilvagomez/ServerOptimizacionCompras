<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "filtrosUsuario".
 *
 * @property integer $id
 * @property integer $idUsuario
 * @property string $DOC_TYPE
 * @property string $CREATED_BY
 * @property string $PUR_GROUP
 * @property string $PLANT
 *
 * @property Usuarios $idUsuario0
 */
class FiltrosUsuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'filtrosUsuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idUsuario'], 'integer'],
            [['DOC_TYPE', 'CREATED_BY', 'PUR_GROUP', 'PLANT'], 'string'],
            [['idUsuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['idUsuario' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idUsuario' => 'Id Usuario',
            'DOC_TYPE' => 'Doc  Type',
            'CREATED_BY' => 'Created  By',
            'PUR_GROUP' => 'Pur  Group',
            'PLANT' => 'Plant',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario0()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'idUsuario']);
    }
}
