<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'authManager' => [
            'class' => 'common\models\AuthAssignment',           
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
