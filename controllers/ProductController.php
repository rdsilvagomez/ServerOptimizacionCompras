<?php

namespace app\controllers;

use Yii;
use app\models\Product;
use app\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
/**
/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends   ActiveController
{
     public $modelClass = 'app\models\ProductSearch';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data',
    ];
   public function actionList ()
   {
      $query = \app\models\ProductSearch::find();
     if (isset($_GET['idProductCategory']))
     {
        $dataProvider = new ActiveDataProvider([
            'query' => $query->andFilterWhere(  ['idProductCategory'=>   $_GET['idProductCategory']])
                             ->andFilterWhere(['like', 'name', $_GET['name']]) 
                             
            ,
        ]);
     }
     else {
  $dataProvider = new ActiveDataProvider([
            'query' => $query->andFilterWhere(['like', 'name', $_GET['name']]) 
                             
            ,
        ]);


     }
      $dataProvider->pagination->pageSize=12;
      return $dataProvider;
   }

    public function actionDel()
    {
    try
    {  
                $request_body = file_get_contents('php://input');
                $data = json_decode($request_body); 
                $Product = \app\models\Product::findOne($data->id);
                $Product->delete(); 
                
        }   
    catch (Exception $e)
    {

        return ['success'=>false];
    }
        return ['success'=>true];

    }

   public function actionNew()
   {
        try
        {
                $request_body = file_get_contents('php://input');
                $data = json_decode($request_body); 
                    
                    $Product= new \app\models\Product(); 
                    $Product->name =  $data[0]->name;
                    $Product->idProductCategory= $data[1]->idProductCategory;
                    $Product->save(); 
        }
        catch (Exception $e)
        {
          return ['success'=>false];
        }
          return ['success'=>true];
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
