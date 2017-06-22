<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
        'controllerMap' => [
        'usuario'=>[
            'class'=> 'app\controllers\usuariosController',
         ],
         'filtrousuario'=>[
            'class'=> 'app\controllers\FiltrosUsuarioController',
         ],
         'solicitudcotizacionsap'=> [
            'class' => 'app\controllers\SolicitudCotizacionSapCapController',
        ],
        'posicionesDisponibles'=> [
            'class' => 'app\controllers\CarguePosicionesLibresController',
        ],
        'grupos'=> [
            'class' => 'app\controllers\GrupoController',
        ],
          'proveedor'=> [
            'class' => 'app\controllers\ProveedoresController',
        ],
         'grupoproveedores'=> [
            'class' => 'app\controllers\GrupoProveedoresController',
        ],
         'grupoposiciones'=> [
            'class' => 'app\controllers\GrupoPosicionesController',
        ],
         'solicitudcotizaciones'=> [
            'class' => 'app\controllers\SolicitudCotizacionCabController',
        ],
           'solicitudcotizacionesdetalle'=> [
            'class' => 'app\controllers\SolicitudCotizacionDetalleController',
        ],
            'login'=> [
            'class' => 'app\controllers\loginController',
        ],
    ],
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
    'authManager' => [
            'class' => 'yii\rbac\DbManager',
            /*'defaultRoles' => ['admin', 'proveedor'],*/
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'YsJ-vlaY91ZRBLp77cWseQqPIzlDfFcG',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Usuarios',
            'enableAutoLogin' => true,
            'enableSession' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        
        'urlManager' => [
            'enablePrettyUrl' => false  ,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
