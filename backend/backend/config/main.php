<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), 
        require(__DIR__ . '/../../common/config/params-local.php'), 
        require(__DIR__ . '/params.php'), 
        require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        // 'user' => [
        //     //'class' => 'dektrium\user\Module',
        //     // 'enableUnconfirmedLogin' => true,
        //     // 'confirmWithin' => 21600,
        //     // 'cost' => 12,
        //     // 'admins' => ['admin'] // User ใหญ่
        // ],
        /*'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'dektrium\user\models\User',
                //เรียกใช้โมดูล user ของ dektrium
                ]
            ],
        ],*/
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:Y-m-d',
            'datetimeFormat' => 'php:Y-m-d H:i:s',
            'timeFormat' => 'php:H:i:s',
            'timeZone' => 'Asia/Bangkok',
        ],
        // 'user' => [
            //'identityClass' => 'common\models\User',
        //     //'identityClass' => 'dektrium\user\models\User', //ของ yii2-user
            //'enableAutoLogin' => false,
            //'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        // ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'trace'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'Upload' => [
            'class' => 'app\components\UploadComponent',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */

    ],
    // 'as access' => [
    //     'class' => 'mdm\admin\components\AccessControl',
    //     'allowActions' => [
    //         //module, controller, action ที่อนุญาตให้ทำงานโดยไม่ต้องผ่านการตรวจสอบสิทธิ์
    //         //'site/*',
    //         //'admin/*',
    //         //'some-controller/some-action',
    //     ]
    // ],
    'params' => $params,
    'defaultRoute' => 'account/login', //first page
];
