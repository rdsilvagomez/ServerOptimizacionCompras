<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "PosicionesProveedores".
 *
 * @property integer $id
 * @property string $numeroSolped
 * @property string $posicion
 * @property integer $idProveedor
 * @property integer $asociado
 *
 * @property Proveedores $idProveedor0
 */
class PosicionesProveedores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PosicionesProveedores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numeroSolped', 'posicion'], 'string'],
            [['idProveedor', 'asociado'], 'integer'],
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
            'numeroSolped' => 'Numero Solped',
            'posicion' => 'Posicion',
            'idProveedor' => 'Id Proveedor',
            'asociado' => 'Asociado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProveedor0()
    {
        return $this->hasOne(Proveedores::className(), ['id' => 'idProveedor']);
    }
}
