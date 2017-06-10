<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SolicitudCotizacionSapDet".
 *
 * @property integer $id
 * @property integer $idSolicitudSapCap
 * @property string $NUMERO_SOLPED
 * @property string $PREQ_ITEM
 * @property string $CANTIDAD
 * @property string $PRECIOUNITARIO
 *
 * @property SolicitudCotizacionSapCap $idSolicitudSapCap0
 */
class SolicitudCotizacionSapDet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SolicitudCotizacionSapDet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idSolicitudSapCap'], 'integer'],
            [['NUMERO_SOLPED', 'PREQ_ITEM'], 'string'],
            [['CANTIDAD', 'PRECIOUNITARIO'], 'number'],
            [['idSolicitudSapCap'], 'exist', 'skipOnError' => true, 'targetClass' => SolicitudCotizacionSapCap::className(), 'targetAttribute' => ['idSolicitudSapCap' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idSolicitudSapCap' => 'Id Solicitud Sap Cap',
            'NUMERO_SOLPED' => 'Numero  Solped',
            'PREQ_ITEM' => 'Preq  Item',
            'CANTIDAD' => 'Cantidad',
            'PRECIOUNITARIO' => 'Preciounitario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSolicitudSapCap0()
    {
        return $this->hasOne(SolicitudCotizacionSapCap::className(), ['id' => 'idSolicitudSapCap']);
    }
}
