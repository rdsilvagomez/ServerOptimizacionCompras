<?php

namespace app\controllers;

use Yii;
use app\models\GrupoPosiciones;
use app\models\GrupoPosicionesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
/**
 * GrupoPosicionesController implements the CRUD actions for GrupoPosiciones model.
 */
class GrupoPosicionesController extends ActiveController
{
      public $modelClass = 'app\models\GrupoPosicionesSearch';
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
 
$query = \app\models\GrupoPosicionesSearch::find();
$dataProvider = new ActiveDataProvider([
    'query' => $query->andFilterWhere(['like', 'id', $_GET['codigo']])
                             ->andFilterWhere(['like', 'descripcion', $_GET['descripcion']]),
                'pagination' => ['pageSize'   => 10,],
        ]);

    return $dataProvider;

    }
}
