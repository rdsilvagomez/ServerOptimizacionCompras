<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "CarguePosicionesLibres".
 *
 * @property integer $ID
 * @property string $NUMERO_SOLPED
 * @property string $PREQ_ITEM
 * @property string $DOC_TYPE
 * @property string $CREATED_BY
 * @property string $CH_ON
 * @property string $PREQ_NAME
 * @property string $SHORT_TEXT
 * @property string $MATERIAL
 * @property string $MATERIAL_EXTERNAL
 * @property integer $HABILITADO
 * @property string $FECHA
 * @property string $PUR_GROUP
 * @property string $PUR_MAT
 * @property string $PLANT
 * @property string $STORE_LOC
 * @property string $UNIT
 * @property string $UNITDES
 * @property double $QUANTITY
 */
class CarguePosicionesLibres extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'CarguePosicionesLibres';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NUMERO_SOLPED', 'PREQ_ITEM', 'DOC_TYPE', 'CREATED_BY', 'CH_ON', 'PREQ_NAME', 'SHORT_TEXT', 'MATERIAL', 'MATERIAL_EXTERNAL', 'PUR_GROUP', 'PUR_MAT', 'PLANT', 'STORE_LOC', 'UNIT', 'UNITDES'], 'string'],
            [['HABILITADO'], 'integer'],
            [['FECHA'], 'safe'],
            [['QUANTITY'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'NUMERO_SOLPED' => 'Numero  Solped',
            'PREQ_ITEM' => 'Preq  Item',
            'DOC_TYPE' => 'Doc  Type',
            'CREATED_BY' => 'Created  By',
            'CH_ON' => 'Ch  On',
            'PREQ_NAME' => 'Preq  Name',
            'SHORT_TEXT' => 'Short  Text',
            'MATERIAL' => 'Material',
            'MATERIAL_EXTERNAL' => 'Material  External',
            'HABILITADO' => 'Habilitado',
            'FECHA' => 'Fecha',
            'PUR_GROUP' => 'Pur  Group',
            'PUR_MAT' => 'Pur  Mat',
            'PLANT' => 'Plant',
            'STORE_LOC' => 'Store  Loc',
            'UNIT' => 'Unit',
            'UNITDES' => 'Unitdes',
            'QUANTITY' => 'Quantity',
        ];
    }
}
