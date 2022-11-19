<?php
return [
    'id' => 'yii2-uuid-tests',
    'class' => \yii\console\Application::class,
    'basePath' => \Yii::getAlias('@tests'),
    'runtimePath' => \Yii::getAlias('@tests/_output'),
    'bootstrap' => ['log'],
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'username' => 'db_username',
            'password' => 'db_password',
            'charset' => 'utf8'
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget'
                ],
            ],
        ],
    ]
];
