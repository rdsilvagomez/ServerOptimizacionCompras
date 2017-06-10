<?php

namespace app\controllers;

use Yii;
use app\models\SolicitudCotizacionDetalle;
use app\models\SolicitudCotizacionDetalleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

/**
 * SolicitudCotizacionDetalleController implements the CRUD actions for SolicitudCotizacionDetalle model.
 */
class SolicitudCotizacionDetalleController extends ActiveController
{
    
 public $modelClass = 'app\models\SolicitudCotizacionDetalleSearch';
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
        /*$query = \app\models\SolicitudCotizacionDetalleSearch::find();
        if (isset($_GET['idencabezado']))
        {
             $query->andFilterWhere(['=', 'idSolicitudCotizacionCab', $_GET['idencabezado']]);
        }
      
        $dataProvider = new ActiveDataProvider([
                                          'query' => $query,
                                          'pagination' => ['pageSize'   => 10,],
                                             ]);

        return $dataProvider;   */
            $db = Yii::$app->db;
    $command = $db->createCommand("Select * from SolicitudCotizacionDetalle det where dbo.CotizacionDetEsProveedorHabilitado(det.idSolicitudCotizacionCab,(Select coalesce(idProveedor,0)  from Usuarios  where id = ".Yii::$app->user->getId()."),det.NUMERO_SOLPED,det.PREQ_ITEM) =1 and idSolicitudCotizacionCab=". $_GET['idencabezado']);
    $result = $command->queryAll();
    
    $rest = array ('data'=>$result,'message'=>'ok','success'=>true );
    echo json_encode($rest);
 
                                    }
    
}
