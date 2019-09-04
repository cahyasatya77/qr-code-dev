<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'name' => 'QR-Code',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\Api',
        ],
    ],
    'homeUrl'=>'/qr-code-dev/backend/web',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend-qr-dev',
            'baseUrl' => '/qr-code-dev/backend/web'
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'class' => 'backend\components\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'generatekode' => [
            'class' => 'backend\components\Generatekode',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-qrcode-dev',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                //'<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];
