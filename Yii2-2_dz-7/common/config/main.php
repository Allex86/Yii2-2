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
            'on '.\common\services\ProjectService::EVENT_ASSIGN_ROLE => function($e)
            {
                $views =['html' => 'assignRoleToProject-html', 'text' => 'assignRoleToProject-text'];
                $data = ['project' => $e->project, 'user' => $e->user, 'role' => $e->role];
                Yii::$app->emailService->send($e->user->email, 'New role'.$e->role, $views, $data);
            }
        ],
        'emailService' => [
            'class' => \common\services\EmailService::className(),
        ],
    ],
    'modules' => [
        'chat' => [
            'class' => 'common\modules\chat\Module',
        ],
    ],
];
