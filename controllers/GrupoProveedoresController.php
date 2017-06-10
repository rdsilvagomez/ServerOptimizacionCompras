<?php

namespace app\controllers;

use Yii;
use app\models\GrupoProveedores;
use app\models\GrupoProveedoresSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GrupoProveedoresController implements the CRUD actions for GrupoProveedores model.
 */
class GrupoProveedoresController extends Controller
{
       public $modelClass = 'app\models\GrupoProveedoresSearch';
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
 
$query = \app\models\GrupoProveedoresSearch::find();
$dataProvider = new ActiveDataProvider([
    'query' => $query->andFilterWhere(['like', 'id', $_GET['codigo']])
                             ->andFilterWhere(['like', 'descripcion', $_GET['descripcion']]),
                'pagination' => ['pageSize'   => 10,],
        ]);

    return $dataProvider;

    }
}
