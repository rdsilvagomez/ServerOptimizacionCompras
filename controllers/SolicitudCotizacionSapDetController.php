<?php

namespace app\controllers;

use Yii;
use app\models\SolicitudCotizacionSapDet;
use app\models\SolicitudCotizacionSapDetSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\filters\AccessControl;
/**
/**
 * SolicitudCotizacionSapDetController implements the CRUD actions for SolicitudCotizacionSapDet model.
 */
class SolicitudCotizacionSapDetController extends ActiveController
{
      public $modelClass = 'app\models\SolicitudCotizacionSapDetSearch';
       public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data',
    ];
}
