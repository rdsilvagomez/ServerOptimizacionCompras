<?php

namespace app\controllers;

use Yii;
use app\models\Grupos;
use app\models\GrupoSearch;
use app\models\GrupoPosicionesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use app\models\GrupoPosiciones; 
/**
 * GrupoController implements the CRUD actions for Grupos model.
 */
class GrupoController extends ActiveController
{
     public $modelClass = 'app\models\GrupoSearch';
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
public function actionList()    {

   $query = \app\models\GrupoSearch::find()->andFilterWhere(['like', 'id', $_GET['codigo']])
                             ->andFilterWhere(['like', 'descripcion', $_GET['descripcion']]);
   
   $dataProvider = new ActiveDataProvider([
    'query' => $query,
                'pagination' => ['pageSize'   => 10,],
        ]);

    return $dataProvider;                             
 
}

public function actionActualizar()
{
   $json = file_get_contents('php://input');
   $obj  = json_decode($json, TRUE);
   $Grupo =   Grupos::findOne($obj['id'] );
  

   $Grupo->descripcion = $obj['descripcion'];
   $Grupo->save(); 
   $rest = array ('data'=>[],'success'=>true);
   echo json_encode($rest);
}


public function actionCrear(){
 
   $json = file_get_contents('php://input');
   $obj  = json_decode($json, TRUE);

   $Grupo = new Grupos() ; 
   $Grupo->descripcion= $obj['descripcion'];
   $Grupo->save(); 
   $rest = array ('data'=>[],'success'=>true);
   echo json_encode($rest);
}

public function actionEliminar()
{
    $json = file_get_contents('php://input');
    $obj  = json_decode($json, TRUE);
    $Grupos = Grupos::findOne( $obj['id'] );
    $Grupos->delete();
    $rest = array ('data'=>[],'success'=>true);
    echo json_encode($rest);
}

public function actionAsociar() {
 

   $json = file_get_contents('php://input');
   $obj  = json_decode($json, TRUE);
   $asociacion =  new  GrupoPosiciones(); 
   
   $asociacion = GrupoPosiciones::findOne([
           'idGrupo' => $obj['idGrupo'],
           'numeroSolped' => $obj['numeroSolped'],
           'posicion' => $obj['posicion']
    ]);
    
  
 if ($asociacion==null)
   {  

       $asociacion =  new  GrupoPosiciones(); 
       $asociacion->idGrupo = $obj['idGrupo'];
       $asociacion->numeroSolped = $obj['numeroSolped'];
       $asociacion->posicion = $obj['posicion'];
       $asociacion->save(); 
   } 
else 
   {
       $asociacion->delete();
   } 
  
    $rest = array ('data'=>[],'success'=>true);
    echo json_encode($rest);
                                }
public function actionFiltrar() {
 
$query = \app\models\GrupoSearch::find()->andFilterWhere(['=', 'id', $_GET['codigo']])
                             ->andFilterWhere(['=', 'descripcion', $_GET['descripcion']]);


 if (ISSET($_GET['seleccion']) && ISSET($_GET['numeroSolped']) && ISSET($_GET['posicion']))
{  
   $subquery= \app\models\GrupoPosicionesSearch::find() 
                             ->andFilterWhere(['numeroSolped'=>$_GET['numeroSolped']])
                             ->andFilterWhere(['posicion'=>$_GET['posicion']])->select('GrupoPosiciones.idGrupo');
 
   switch($_GET['seleccion'])
    {
     case 0:
        $query= $query->andWhere(['not in','Grupos.id',$subquery]);
        break ; 
     case 1:
        $query= $query->andWhere(['in','Grupos.id',$subquery]);
        break ; 
    } 
} 
 
$dataProvider = new ActiveDataProvider([
    'query' => $query,
                'pagination' => ['pageSize'   => 10,],
        ]);

    return $dataProvider;

    }
 


 


     
}
