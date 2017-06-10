<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SolicitudCotizacionSapCap".
 *
 * @property integer $id
 * @property integer $idSolicitudCotizacionCab
 * @property string $fecha
 * @property integer $ENVIADOSAP
 * @property string $LIFNR
 * @property string $STCD1
 * @property integer $idProveedor
 * @property integer $ESMANUAL
 * @property integer $HABILITADO_ENVIO
 *
 * @property Proveedores $idProveedor0
 * @property SolicitudCotizacionCab $idSolicitudCotizacionCab0
 * @property SolicitudCotizacionSapDet[] $solicitudCotizacionSapDets
 */
class SolicitudCotizacionSapCap extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SolicitudCotizacionSapCap';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idSolicitudCotizacionCab', 'ENVIADOSAP', 'idProveedor', 'ESMANUAL', 'HABILITADO_ENVIO'], 'integer'],
            [['fecha'], 'safe'],
            [['LIFNR', 'STCD1'], 'string'],
            [['idProveedor'], 'exist', 'skipOnError' => true, 'targetClass' => Proveedores::className(), 'targetAttribute' => ['idProveedor' => 'id']],
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
            'fecha' => 'Fecha',
            'ENVIADOSAP' => 'Enviadosap',
            'LIFNR' => 'Lifnr',
            'STCD1' => 'Stcd1',
            'idProveedor' => 'Id Proveedor',
            'ESMANUAL' => 'Esmanual',
            'HABILITADO_ENVIO' => 'Habilitado  Envio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProveedor0()
    {
        return $this->hasOne(Proveedores::className(), ['id' => 'idProveedor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSolicitudCotizacionCab0()
    {
        return $this->hasOne(SolicitudCotizacionCab::className(), ['id' => 'idSolicitudCotizacionCab']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicitudCotizacionSapDets()
    {
        return $this->hasMany(SolicitudCotizacionSapDet::className(), ['idSolicitudSapCap' => 'id']);
    }
}
