<?php

namespace app\controllers;

use Yii;
use app\models\proveedores;
use app\models\proveedoresSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use app\models\GrupoProveedores; 
use app\models\PosicionesProveedores; 
use app\models\GrupoProveedoresSearch; 
/**
 * ProveedoresController implements the CRUD actions for proveedores model.
 */
class ProveedoresController extends ActiveController
{
     public $modelClass = 'app\models\proveedoresSearch';
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
public function actionAsociarposicion()
{

    $json = file_get_contents('php://input');
    $obj  = json_decode($json, TRUE);
  
    $asociacion= PosicionesProveedores::findOne([
                    'idProveedor'     => $obj['idProveedor'],
                    'numeroSolped' => $obj['numeroSolped'],
                    'posicion' => $obj['posicion'],
                    'asociado' => $obj['asociar']
                                         ]); 
  
    if($asociacion==null)
    {
        $asociacion =  new  PosicionesProveedores(); 
        $asociacion->idProveedor  = $obj['idProveedor'];
        $asociacion->numeroSolped = $obj['numeroSolped'];
        $asociacion->posicion     = $obj['posicion'];
        $asociacion->asociado     = $obj['asociar'];
        $asociacion->save();  
    }
else {
         $asociacion->delete(); 
     }
 
    $rest = array ('data'=>[],'success'=>true);

    echo json_encode($rest);
}
public function actionAsociar()
{
    $json = file_get_contents('php://input');
    $obj  = json_decode($json, TRUE);
  
    $asociacion= GrupoProveedores::findOne([
                    'idGrupo'     => $obj['idGrupo'],
                    'idProveedor' => $obj['idProveedor']
                                         ]); 
  
    if($asociacion==null)
    {
        $asociacion =  new  GrupoProveedores(); 
        $asociacion->idGrupo = $obj['idGrupo'];
        $asociacion->idProveedor = $obj['idProveedor'];
        $asociacion->save();  
    }
else {
         $asociacion->delete(); 
     }

    $rest = array ('data'=>[],'success'=>true);

    echo json_encode($rest);

}

public function actionFiltrarposicion(){


 $query = \app\models\proveedoresSearch::find()->andFilterWhere(['like', 'id', $_GET['codigo']])
                             ->andFilterWhere(['like', 'descripcion', $_GET['descripcion']]);    

    if (ISSET($_GET['seleccion']) && ISSET($_GET['numeroSolped']) && ISSET($_GET['posicion'])&& ISSET($_GET['codigo']))
     {
            $subquery= \app\models\proveedoresSearch::find()->andFilterWhere(['like', 'id', $_GET['codigo']])
                    ->andFilterWhere(['like', 'descripcion', $_GET['descripcion']])
                    ->innerJoin('PosicionesProveedores','PosicionesProveedores.idProveedor=Proveedores.id')
                    ->select('Proveedores.id')
                    ->andWhere(['=','PosicionesProveedores.numeroSolped',$_GET['numeroSolped']]) 
                    ->andWhere(['=','PosicionesProveedores.posicion',    $_GET['posicion']]) 
                    ->andWhere(['=','PosicionesProveedores.asociado',    $_GET['asociar']]) ;
              switch($_GET['seleccion'])
                    {
                         case 0:
                            $query= $query->andWhere(['not in','Proveedores.id',$subquery]);
                            break ; 
                         case 1:
                            $query= $query->andWhere(['in','Proveedores.id',$subquery]);
                            break ; 
                    }          

     }

     $dataProvider = new ActiveDataProvider([
    'query' => $query,
                'pagination' => ['pageSize'   => 10,],
        ]);

    return $dataProvider;         


 }



public function actionFiltrar(){
 $query = \app\models\proveedoresSearch::find()->andFilterWhere(['like', 'id', $_GET['codigo']])
                             ->andFilterWhere(['like', 'descripcion', $_GET['descripcion']]);
   


    if (ISSET($_GET['grupoid']) &&ISSET($_GET['seleccion']) &&$_GET['grupoid']!= 0 )
    {
    $subquery= \app\models\proveedoresSearch::find()->andFilterWhere(['like', 'id', $_GET['codigo']])
        ->andFilterWhere(['like', 'descripcion', $_GET['descripcion']])
        ->innerJoin('GrupoProveedores','GrupoProveedores.idProveedor=Proveedores.id')
         ->select('Proveedores.id')
          ->andWhere(['=','GrupoProveedores.idGrupo',$_GET['grupoid']])  
         ;

    switch($_GET['seleccion'])
    {
     case 0:
        $query= $query->andWhere(['not in','Proveedores.id',$subquery]);
        break ; 
     case 1:
        $query= $query->andWhere(['in','Proveedores.id',$subquery]);
        break ; 
    }          



    }
   $dataProvider = new ActiveDataProvider([
    'query' => $query,
                'pagination' => ['pageSize'   => 10,],
        ]);

    return $dataProvider;         

 }
public function actionList() {
 
   $query = \app\models\proveedoresSearch::find()->andFilterWhere(['like', 'id', $_GET['codigo']])
                             ->andFilterWhere(['like', 'descripcion', $_GET['descripcion']]);
   
   $dataProvider = new ActiveDataProvider([
    'query' => $query,
                'pagination' => ['pageSize'   => 10,],
        ]);

    return $dataProvider;         
  }
}
