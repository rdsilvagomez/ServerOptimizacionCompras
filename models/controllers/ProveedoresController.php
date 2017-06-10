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
