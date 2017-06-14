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
use app\models\Usuarios;

class usuariosController extends ActiveController
{
     public $modelClass = 'app\models\Usuarios';
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
public function actionIngresar(){

      $rest = array ('message'=>'ok','success'=>true );
      try{
                $json = file_get_contents('php://input');
                $obj  = json_decode($json, TRUE);
                $usuarios =   new \app\models\Usuarios(); 
                $usuarios->firstname   =  $obj['Nombres']; 
                $usuarios->lastname    =  $obj['Apellidos'] ;
                $usuarios->password    =  md5($obj['pwd']) ;
                $usuarios->username =  $obj['Usuario'] ;
                $usuarios->save();    
        }
        catch(\Exception $e)
        {
                $rest = array ('message'=>$e->getMessage(),'success'=>false);

        }
     
       echo json_encode($rest); 
     }
 
 
public function actionList()    {

    $db 		= Yii::$app->db;
	$queryTotal = "select count(1) cantidad from Usuarios"; 
	$command = $db->createCommand($queryTotal);
	$resultado = $command->queryAll();
 

   $page = $_GET['page'] -1; 
 
   $pageSize= 10 ; 
  
   $query   ="Select * from Usuarios ORDER BY ID  OFFSET ".($page*$pageSize)." ROWS  FETCH NEXT ".$pageSize." ROWS ONLY " ; 

   $command = $db->createCommand($query);
   $recProveedor = $command->queryAll();   
   $_meta	= array('totalCount'=>$resultado[0]['cantidad']); 
   $rest    = array ('data'=> $recProveedor,'_meta' =>$_meta);  
   echo json_encode($rest); 
  

 
}

public function actionActualizar()
							   {
 
                    $rest = array ('message'=>'ok','success'=>true );
                    try {

                    $json = file_get_contents('php://input');
                    $obj  = json_decode($json, TRUE);
                    $usuarios = usuarios::findOne( $obj['id'] );
            		    
                    $filtros = \app\models\Usuarios::find()->where(['username' => $obj['username'] ])
                                                          ->andWhere(['<>','id', $obj['id']])->all();

                    if ($filtros== null)
                    {

                        $usuarios->firstname   =  $obj['firstname']; 
                        $usuarios->lastname    =  $obj['lastname'] ;
                        if ($usuarios->password !== $obj['password'])
                        { $usuarios->password    =  md5($obj['password']) ;}
                        $usuarios->idProveedor =  $obj['idProveedor'] ;
                        $usuarios->save(); 

                    }

                    else {

                        $rest = array ('message'=>'Usuario repetido','success'=>false);
                    }
               
                        }
                        catch(\Exception $e)
                        {
                          
                          $rest = array ('message'=>$e->getMessage(),'success'=>false);
                        }
                  
                                  echo json_encode($rest); 
								}


}