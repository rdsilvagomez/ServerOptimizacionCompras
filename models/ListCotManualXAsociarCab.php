<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "listCotManualXAsociarCab".
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
 * @property string $NOMBRE_PROVEEDOR
 */
class ListCotManualXAsociarCab extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'listCotManualXAsociarCab';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'idSolicitudCotizacionCab', 'ENVIADOSAP', 'idProveedor', 'ESMANUAL', 'HABILITADO_ENVIO'], 'integer'],
            [['fecha'], 'safe'],
            [['LIFNR', 'STCD1', 'NOMBRE_PROVEEDOR'], 'string'],
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
            'NOMBRE_PROVEEDOR' => 'Nombre  Proveedor',
        ];
    }
}
