<?php

namespace app\controllers;

use Yii;
use app\models\filtrosUsuario;
use app\models\filtrosUsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
 
/**
 * FiltrosUsuarioController implements the CRUD actions for filtrosUsuario model.
 */
class FiltrosUsuarioController extends ActiveController
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
    public function actionFiltrar() {
                $query = \app\models\filtrosUsuarioSearch::find()->andFilterWhere(['=', 'idUsuario', Yii::$app->user->getId()]);
                $dataProvider = new ActiveDataProvider([
                'query' => $query,
                                'pagination' => ['pageSize'   => 10,],
                    ]);

                    return $dataProvider;        
    }

    public function actionActualizar(){
                $json       = file_get_contents('php://input');
                $obj        = json_decode($json, TRUE);
                $filtros = \app\models\filtrosUsuario::findOne(['idUsuario' => Yii::$app->user->getId()]);

                    if ($filtros== null)
                        {
                            $filtros= new \app\models\filtrosUsuario(); 
                        }
                        
            
                $filtros->idUsuario  = Yii::$app->user->getId();
                $filtros->DOC_TYPE   = $obj ['DOC_TYPE']; 
                $filtros->CREATED_BY = $obj ['CREATED_BY'];   
                $filtros->PUR_GROUP  = $obj ['PUR_GROUP'];   
                $filtros->PLANT      = $obj ['PLANT'];   
                $filtros->save(); 
                $rest = array ('data'=>[],'success'=>true);
                echo json_encode($rest);

                                    }



}
