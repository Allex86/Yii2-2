<?php

namespace common\services;

use Yii;

use common\models\Project;
use common\models\User;
use yii\base\Event;

class EmailService extends \yii\base\Component
{
    public function send($to, $subject, $views, $update)
    {
        \Yii::$app
            ->mailer
            ->compose($views, $update)
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }
}
