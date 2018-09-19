<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'projectService' => [
            'class' => \common\services\ProjectService::className(),
            'on '.\common\services\ProjectService::EVENT_ASSIGN_ROLE => function ($e) {
                $views =['html' => 'assignRoleToProject-html', 'text' => 'assignRoleToProject-text'];
                $data = ['project' => $e->project, 'user' => $e->user, 'role' => $e->role];
                Yii::$app->emailService->send($e->user->email, 'New role'.$e->role, $views, $data);
            }
        ],
        'emailService' => [
            'class' => \common\services\EmailService::className(),
        ],
        'taskService' => [
            'class' => \common\services\TaskService::className(),
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['user_login'],
                    'logFile' => '@runtime/logs/User_log/User_login.log',
                    'logVars' => [],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'categories' => ['user_login_error'],
                    'logFile' => '@runtime/logs/User_log/User_login_error.log',
                    // 'logVars' => [],
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'yii2mod.comments' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/comments/messages',
                ],
            ],
        ],
    ],
    'modules' => [
        'chat' => [
            'class' => 'common\modules\chat\Module',
        ],
        'comment' => [
            'class' => 'yii2mod\comments\Module',
        ],
    ],
];
