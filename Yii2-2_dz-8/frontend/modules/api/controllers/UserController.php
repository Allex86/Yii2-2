<?php

namespace frontend\modules\api\controllers;

use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'frontend\modules\api\models\UserApi';
}
