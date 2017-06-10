<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "GrupoProveedores".
 *
 * @property integer $id
 * @property integer $idGrupo
 * @property integer $idProveedor
 *
 * @property Grupos $idGrupo0
 * @property Proveedores $idProveedor0
 */
class GrupoProveedores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'GrupoProveedores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idGrupo', 'idProveedor'], 'integer'],
            [['idGrupo'], 'exist', 'skipOnError' => true, 'targetClass' => Grupos::className(), 'targetAttribute' => ['idGrupo' => 'id']],
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
            'idGrupo' => 'Id Grupo',
            'idProveedor' => 'Id Proveedor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdGrupo0()
    {
        return $this->hasOne(Grupos::className(), ['id' => 'idGrupo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProveedor0()
    {
        return $this->hasOne(Proveedores::className(), ['id' => 'idProveedor']);
    }
}
