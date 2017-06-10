<?php

namespace app\controllers;

use Yii;
use app\models\SolicitudCotizacionSapCap;
use app\models\SolicitudCotizacionSapCapSearch;
use app\models\SolicitudCotizacionSapDet;
use app\models\SolicitudCotizacionSapDetSearch;
use app\models\SolicitudCotizacionCab; 
use app\models\Proveedores; 

use app\models\ListCotManualXAsociarCab; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\filters\AccessControl;
/**
/**
 * SolicitudCotizacionSapCapController implements the CRUD actions for SolicitudCotizacionSapCap model.
 */
class SolicitudCotizacionSapCapController extends ActiveController
{
      public $modelClass = 'app\models\SolicitudCotizacionSapCapSearch';
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

public function actionGuardarasoc()
{

   $rest = array ('message'=>'ok','success'=>true );
   $json = file_get_contents('php://input');
   $obj  = json_decode($json, TRUE);
    $idSolicitudCotizacionCab= 0 ;  
  foreach( $obj['listado'] as $reg)
    {

       $SolicitudSapDet = SolicitudCotizacionSapDetSearch::findOne([
            'id' => $reg['id'] ]);
       $SolicitudSapDet->NUMERO_SOLPED= $reg['NUMERO_SOLPED']; 
       $SolicitudSapDet->PREQ_ITEM= $reg['PREQ_ITEM']; 
       $idSolicitudCotizacionCab=  $SolicitudSapDet->idSolicitudSapCap ; 
       $SolicitudSapDet->save(); 
           }       
   $SolicitudCotizacionSapCab=SolicitudCotizacionSapCapSearch::findOne(['id'=>$idSolicitudCotizacionCab]);
   $SolicitudCotizacionSapCab->HABILITADO_ENVIO = 1;
   $SolicitudCotizacionSapCab->save(); 
   echo json_encode($rest);

}
public function actionListarmansinasocdet() 
{

 $query = \app\models\SolicitudCotizacionSapDetSearch::find();
 if (isset($_GET['idencabezado']))
  {
             $query->andFilterWhere(['=', 'idSolicitudSapCap', $_GET['idencabezado']]);
  }

      $dataProvider = new ActiveDataProvider([
        'query' => $query,
               'pagination' => ['pageSize'   => 10,], 
            ]);

    return $dataProvider;

  
}

public function actionListarmansinasoc()
{
 
 $query = \app\models\SolicitudCotizacionSapCap::find()->andFilterWhere(['=','ESMANUAL',1])->andFilterWhere(['=','HABILITADO_ENVIO',0])
 ;

      $dataProvider = new ActiveDataProvider([
        'query' => $query,
               'pagination' => ['pageSize'   => 10,], 
            ]);

    return $dataProvider;

}
    public function actionEnviarcotsaparchivo()
    {
                    
                    $db = Yii::$app->db;
                    $command = $db->createCommand("Select * from Proveedores 
                              Where id in (Select idProveedor from   Usuarios   where id=".Yii::$app->user->getId().")" );
                       $recProveedor = $command->queryAll();
                      
                
                    $rest        = []; 
                    $db          = Yii::$app->db;
                    $transaction = $db->beginTransaction();
            try {
                    $cotizacion =  new  SolicitudCotizacionCab(); 
                    $cotizacion = SolicitudCotizacionCab::findOne(['id' => $_POST['idSolicitudCotizacionCab'] ]);
                    $cotizacion->HABILITADO_COTIZACION= 0; 
                    $esCotizacionManual= $cotizacion->esCotizacionManual; 
                    $cotizacion->save(); 
                  
                    $encabezado = new \app\models\SolicitudCotizacionSapCap();
                    $encabezado->idSolicitudCotizacionCab =  $_POST['idSolicitudCotizacionCab']; 
                    $encabezado->LIFNR                    =  $recProveedor[0]['numeroCuenta'];     
                    $encabezado->STCD1                    =  $recProveedor[0]['nit'];
                    $encabezado->ESMANUAL                 =  $esCotizacionManual;
                    $encabezado->HABILITADO_ENVIO         =  ($esCotizacionManual==0?1:0);
                    $encabezado->idProveedor              =  $recProveedor[0]['id']; 
                    $encabezado->save(); 
                    $arreglo_detalle= json_decode($_POST['listado'],true); 
                   
                    foreach(  $arreglo_detalle as $reg)
                    {
                        $detalle = new \app\models\SolicitudCotizacionSapDet();
                        $detalle->NUMERO_SOLPED      =  $reg['NUMERO_SOLPED'];
                        $detalle->PREQ_ITEM          =  $reg['PREQ_ITEM'];
                        $detalle->CANTIDAD           =  $reg['CANTIDAD'];
                        $detalle->PRECIOUNITARIO     =  $reg['PRECIOUNITARIO'];
                        $detalle->idSolicitudSapCap  = $encabezado->id;
                        $detalle->save(); 
                    }
                    $rest = array ('message'=>'ok','success'=>true );
                    $transaction->commit();
                    }
            catch(\Exception $e) 
                    { 
                        $rest = array ('message'=> $e->getMessage(),'success'=>false);
                        $transaction->rollBack();
                     } 

            echo json_encode($rest);
            $target_dir = "\\\\10.1.2.32\osticket\\cotizaciones\\";
            $target_file = $target_dir . basename($_FILES["uploadFile"]["name"]);
            move_uploaded_file($_FILES["uploadFile"]["tmp_name"], $target_file);
    }
    
    public function actionEnviarcotsap()
    {


                   $db = Yii::$app->db;
                       $command = $db->createCommand("Select * from Proveedores 
                              Where id in (Select idProveedor from   Usuarios   where id=".Yii::$app->user->getId().")" );
                       $recProveedor = $command->queryAll();
            $db          = Yii::$app->db;
            $transaction = $db->beginTransaction();
        try {
            $json = file_get_contents('php://input');
            $obj  = json_decode($json, TRUE);
           
            $cotizacion =  new  SolicitudCotizacionCab(); 
   
            $cotizacion = SolicitudCotizacionCab::findOne([
            'id' => $obj['idSolicitudCotizacionCab'] ]);
            $cotizacion->HABILITADO_COTIZACION= 0; 
            $esCotizacionManual= $cotizacion->esCotizacionManual; 
            $cotizacion->save(); 
             
            $encabezado = new \app\models\SolicitudCotizacionSapCap();
            $encabezado->idSolicitudCotizacionCab=$obj['idSolicitudCotizacionCab']; 
            $encabezado->LIFNR                    =  $recProveedor[0]['numeroCuenta'];     
            $encabezado->STCD1                    =  $recProveedor[0]['nit'];
            $encabezado->idProveedor              =  $recProveedor[0]['id']; 
            $encabezado->ESMANUAL=  $esCotizacionManual;
            $encabezado->HABILITADO_ENVIO = ($esCotizacionManual==0?1:0);
            

            $encabezado->save(); 
              
              foreach( $obj['listado'] as $reg)
              {
                    $detalle = new \app\models\SolicitudCotizacionSapDet();
                    $detalle->NUMERO_SOLPED = $reg['NUMERO_SOLPED'];
                    $detalle->PREQ_ITEM     = $reg['PREQ_ITEM'];
                    $detalle->CANTIDAD           =  $reg['CANTIDAD'];
                    $detalle->PRECIOUNITARIO     =  $reg['PRECIOUNITARIO'];
                    
                    $detalle->idSolicitudSapCap  = $encabezado->id;
                    $detalle->save(); 
             }

            $rest = array ('message'=>'ok','success'=>true );
            $transaction->commit();
            
    }
            catch(\Exception $e) 
                    { 
                        $rest = array ('message'=> $e->getMessage(),'success'=>false);
                        $transaction->rollBack();
                       
                        
                     } 

            echo json_encode($rest);


    }


}
