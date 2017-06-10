<?php

namespace app\controllers;

use Yii;
use app\models\CarguePosicionesLibres;
use app\models\CarguePosicionesLibresSearch;
use app\models\SolicitudCotizacionCab;
use app\models\SolicitudCotizacionDetalle;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\filters\AccessControl;
/**
 * CarguePosicionesLibresController implements the CRUD actions for CarguePosicionesLibres model.
 */
class CarguePosicionesLibresController extends    ActiveController
{
       public $modelClass = 'app\models\CarguePosicionesLibresSearch';
       public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data',
    ];



 public function actionSequencia()
 {
    
    $db = Yii::$app->db;
    $command = $db->createCommand("SELECT NEXT VALUE    FOR  SeqPosicionesMantenimiento   SequenciaManual");
    $result = $command->queryAll();
    
    $rest = array ('data'=>$result,'message'=>'ok','success'=>true );
    echo json_encode($rest);
 }
 public function actionSolicitarcot()
 {
      
  $db = Yii::$app->db;
  $transaction = $db->beginTransaction();
  try {
                $json = file_get_contents('php://input');
                $obj  = json_decode($json, TRUE);
           
                $encabezado = new \app\models\SolicitudCotizacionCab();
                $encabezado->descripcion=$obj['informacion']; 
                $encabezado->esCotizacionManual=$obj['esmanual']; 
                $encabezado->save(); 
              
            

              foreach( $obj['listado'] as $reg)
              {
                    $detalle = new \app\models\SolicitudCotizacionDetalle();
                   
                    $detalle->SHORT_TEXT    = $reg['SHORT_TEXT'];
                    $detalle->MATERIAL      = $reg['MATERIAL'];
                    if ($obj['esmanual']===0)
                    {
                          $detalle->NUMERO_SOLPED = $reg['NUMERO_SOLPED'];
                          $detalle->PREQ_ITEM     = $reg['PREQ_ITEM'];
                          $detalle->CANTIDAD      = $reg['CANTIDAD'];
                    }
                    else {
                          $detalle->CANTIDAD     =$reg['CANTIDAD'];
                    }
                    $detalle->PRECIOUNITARIO     = 0 ; 
                    $detalle->idSolicitudCotizacionCab= $encabezado->id;
                    $detalle->save(); 
             }

            $rest = array ('message'=>'ok','success'=>true );
            $transaction->commit();
            
    }
            catch(\Exception $e) 
                    { 
                        $rest = array ('message'=>$e->getMessage(),'success'=>false);
                        $transaction->rollBack();
                       
                        
                     } 

echo json_encode($rest);
  
 }
public function actionSincposlibres(){
   $rest ; 
  try {

  \Yii::$app->db->createCommand("exec pa_sincroniza_posiciones_libres")->execute();
       $rest = array ('message'=>'ok','success'=>true);
}
catch(\Exception $ex )
{$rest = array ('message'=>$ex->message,'success'=>false);
}
 
     

echo json_encode($rest);
}

public function actionList() {
 $filtros = \app\models\filtrosUsuario::findOne(['idUsuario' => Yii::$app->user->getId()]);
 

$query = \app\models\CarguePosicionesLibresSearch::find();
$dataProvider = new ActiveDataProvider([
    'query' => $query->andFilterWhere(['like', 'NUMERO_SOLPED', $_GET['solped']])
                     ->andFilterWhere(['like', 'PREQ_ITEM', $_GET['posicion']])
                     ->andFilterWhere(['like', 'DOC_TYPE', $filtros->DOC_TYPE])
                     ->andFilterWhere(['like', 'CREATED_BY', $filtros->CREATED_BY])
                     ->andFilterWhere(['like', 'PUR_GROUP', $filtros->PUR_GROUP])
                     ->andFilterWhere(['like', 'PLANT', $filtros->PLANT])
                     ,

                'pagination' => ['pageSize'   => 10,],
        ]);

    return $dataProvider;

    }
 
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
        /*return [
        'access' => [
                'class' => AccessControl::className(),
                 
                'rules' => [
                              [
                                  'allow' => true ,
                                  'actions' => ['solicitarcot'],
                                  'roles' => ['admin'],
                                   'denyCallback' => function ($rule, $action) {
                                        echo 'You are not allowed to access this page';
                                                                               }
                              ] , 
                              [
                                  'allow' => true,
                                  'actions' => ['list'],
                                  'roles' => ['proveedor','admin'],
                                   'denyCallback' => function ($rule, $action) {
                                        echo 'You are not allowed to access this page';
                                                                               }
                              ] ,
                    ]],
              [
                 'class'   => \yii\filters\ContentNegotiator::className(),
                 'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                              ],
              ],
        ];*/
}
     
}
