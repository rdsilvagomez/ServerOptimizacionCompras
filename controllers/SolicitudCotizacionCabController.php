<?php

namespace app\controllers;

use Yii;
use app\models\SolicitudCotizacionCab;
use app\models\SolicitudCotizacionCabSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;


class SolicitudCotizacionCabController extends ActiveController
{
      public $modelClass = 'app\models\SolicitudCotizacionCabSearch';
       public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data',
    ];
   public function behaviors()
   {
        return [
            [
                 'class' => \yii\filters\ContentNegotiator::className(),
                    'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
 
            ],
        ];
    }



    public function actionList() {
      /*$query = \app\models\SolicitudCotizacionCabSearch::find()->andFilterWhere(['=', 'HABILITADO_COTIZACION', 1]);
   
      $dataProvider = new ActiveDataProvider([
                                          'query' => $query,
                                          'pagination' => ['pageSize'   => 10,],
                                             ]);

    return $dataProvider;   */

     $db = Yii::$app->db;
    $command = $db->createCommand("Select * from SolicitudCotizacionCab cab where habilitado_cotizacion= 1 and dbo.CotizacionEsProveedorHabilitado(cab.id,(Select coalesce(idProveedor,0)  from Usuarios  where id = ".Yii::$app->user->getId()."))=1 ");
    $result = $command->queryAll();
    
    $rest = array ('data'=>$result,'message'=>'ok','success'=>true );
    echo json_encode($rest);


    }

    
}
