<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "GrupoPosiciones".
 *
 * @property integer $id
 * @property integer $idGrupo
 * @property string $numeroSolped
 * @property string $posicion
 */
class GrupoPosiciones extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'GrupoPosiciones';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idGrupo'], 'integer'],
            [['numeroSolped', 'posicion'], 'string'],
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
            'numeroSolped' => 'Numero Solped',
            'posicion' => 'Posicion',
        ];
    }
}
