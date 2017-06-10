<?php

namespace app\controllers;

use Yii;
use app\models\CarguePosicionesLibres;
use app\models\CarguePosicionesLibresSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
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
 
public function actionList() {
/* para el filtrado mas adelante debe funcionar así
 'query' => 
*/
$query = \app\models\CarguePosicionesLibresSearch::find();
$dataProvider = new ActiveDataProvider([
    'query' => $query->andFilterWhere(['like', 'NUMERO_SOLPED', $_GET['solped']])
                             ->andFilterWhere(['like', 'PREQ_ITEM', $_GET['posicion']]),
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
}
     
}
