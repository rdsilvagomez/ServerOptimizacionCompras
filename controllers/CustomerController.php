<?php

namespace app\controllers;

use Yii;
use app\models\Customer;
use app\models\CustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends ActiveController
{
     public $modelClass = 'app\models\CustomerSearch';
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
                $Customer = \app\models\Customer::findOne($data->id);
                $Customer->delete(); 
                
        }   
    catch (Exception $e)
    {

        return ['success'=>false];
    }
        return ['success'=>true];

    }
public function actionNew ()
   {
                  $request_body = file_get_contents('php://input');
                   $data = json_decode($request_body);
                   $Customer = new \app\models\Customer(); 
                   $Customer->name =  $data[0]->name;
                   $Customer->LastName =  $data[0]->LastName;
                   $Customer->FullName =  $data[0]->FullName;
                   $Customer->Credit =  $data[0]->Credit;
                   $Customer->save(); 

                   // echo  $data[0]->name ;

   }
public function actionList () 
{
   $query = \app\models\CustomerSearch::find();
     $dataProvider = new ActiveDataProvider([
            'query' => $query 
                             
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
