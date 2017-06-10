<?php

namespace app\controllers;

use Yii;
use app\models\ProductCategory;
use app\models\ProductCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
/**
 * ProductCategoryController implements the CRUD actions for ProductCategory model.
 */
class ProductCategoryController extends   ActiveController
{
     public $modelClass = 'app\models\ProductCategorySearch';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data',
    ];
    public function actionDel()
    {
      try
      {  
                $request_body = file_get_contents('php://input');
                $data         = json_decode($request_body); 
                $ProductCategory = \app\models\ProductCategory::findOne($data->id);
                $ProductCategory->delete(); 
                
        }   
    catch (Exception $e)
    {

        return ['success'=>false];
    }
        return ['success'=>true];

    }
   public function actionNew ()
   {
      try {
                   $request_body = file_get_contents('php://input');
                   $data = json_decode($request_body);
                   $ProductCategoryRecord= new \app\models\ProductCategory(); 
                   $ProductCategoryRecord->name =  $data->name;
                   $ProductCategoryRecord->save(); 
          
          }
        catch (Exception $e)
        {
                    return ['success'=>false];
        }
        return ['success'=>true];
   } 
  public function actionList ()
   {
      $query = \app\models\ProductCategorySearch::find();
     $dataProvider = new ActiveDataProvider([
            'query' => $query->andFilterWhere(['like', 'name', $_GET['name']]) 
                             
            ,
        ]);
      $dataProvider->pagination->pageSize=12;
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
