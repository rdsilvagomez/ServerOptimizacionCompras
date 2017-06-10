<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SolicitudCotizacionCab".
 *
 * @property integer $id
 * @property string $descripcion
 * @property string $fecha
 * @property integer $esCotizacionManual
 * @property integer $HABILITADO_COTIZACION
 *
 * @property SolicitudCotizacionDetalle[] $solicitudCotizacionDetalles
 * @property SolicitudCotizacionSapCap[] $solicitudCotizacionSapCaps
 */
class SolicitudCotizacionCab extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SolicitudCotizacionCab';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string'],
            [['fecha'], 'safe'],
            [['esCotizacionManual', 'HABILITADO_COTIZACION'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'fecha' => 'Fecha',
            'esCotizacionManual' => 'Es Cotizacion Manual',
            'HABILITADO_COTIZACION' => 'Habilitado  Cotizacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitudCotizacionDetalles()
    {
        return $this->hasMany(SolicitudCotizacionDetalle::className(), ['idSolicitudCotizacionCab' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitudCotizacionSapCaps()
    {
        return $this->hasMany(SolicitudCotizacionSapCap::className(), ['idSolicitudCotizacionCab' => 'id']);
    }
}
