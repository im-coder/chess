<?php

return [
    'id' => 'console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'micro\migrations',
    'aliases' => [
        '@micro' => dirname(__DIR__),
    ],
    'components' => [
        'db' => require __DIR__ . '/db.php',
    ],
];
