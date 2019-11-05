<?php

return [
    'id' => 'chess-service',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'micro\controllers',
    'aliases' => [
        '@micro' => dirname(__DIR__),
    ],
    'components' => [
        'db' => require __DIR__ . '/db.php',
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
        ],
    ],
    'language' => 'ru',
];
