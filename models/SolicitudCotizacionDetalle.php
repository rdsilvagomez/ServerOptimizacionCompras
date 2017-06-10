<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SolicitudCotizacionDetalle".
 *
 * @property integer $id
 * @property integer $idSolicitudCotizacionCab
 * @property string $NUMERO_SOLPED
 * @property string $PREQ_ITEM
 * @property string $SHORT_TEXT
 * @property string $MATERIAL
 * @property integer $cantidad
 *
 * @property SolicitudCotizacionCab $idSolicitudCotizacionCab0
 */
class SolicitudCotizacionDetalle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SolicitudCotizacionDetalle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idSolicitudCotizacionCab', 'CANTIDAD'], 'integer'],
            [['NUMERO_SOLPED', 'PREQ_ITEM', 'SHORT_TEXT', 'MATERIAL'], 'string'],
             [['PRECIOUNITARIO'],'double'], 
            [['idSolicitudCotizacionCab'], 'exist', 'skipOnError' => true, 'targetClass' => SolicitudCotizacionCab::className(), 'targetAttribute' => ['idSolicitudCotizacionCab' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idSolicitudCotizacionCab' => 'Id Solicitud Cotizacion Cab',
            'NUMERO_SOLPED' => 'Numero  Solped',
            'PREQ_ITEM' => 'Preq  Item',
            'SHORT_TEXT' => 'Short  Text',
            'MATERIAL' => 'Material',
            'CANTIDAD' => 'Cantidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSolicitudCotizacionCab0()
    {
        return $this->hasOne(SolicitudCotizacionCab::className(), ['id' => 'idSolicitudCotizacionCab']);
    }
}
