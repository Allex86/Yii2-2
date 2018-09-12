<?php

namespace frontend\controllers\api;

use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\models_for_api\UserApi';
}
