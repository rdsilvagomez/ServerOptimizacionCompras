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
use app\models\GrupoProveedoresSearch; 
use app\models\LoginForm;
/**
 * ProveedoresController implements the CRUD actions for proveedores model.
 */
class loginController extends ActiveController
{
  public $modelClass = 'app\models\Usuarios';
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

   
   public function actionValidarlogin()
	{

	 
            $auth = \Yii::$app->authManager;
	          $json = file_get_contents('php://input');
            $obj  = json_decode($json, TRUE);
          
    

            $model = new LoginForm();
            $model->username= $obj['username'];
            $model->password= $obj['password'];
	 
           
       
        if ( $model->login()) 
        	{       
               $roles = \Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId());  
               $data = array ( 'username'=> $obj['username'],'role'=> array_values($roles)[0]->name); 
               $rest = array ('data'=>$data,'success'=>true,);
        		   echo json_encode($rest);														 
        	}
        	else 
        	{   
        		   $rest = array ('message'=>'','success'=>false);
        		    echo json_encode($rest);			
         }
  
  	}




}