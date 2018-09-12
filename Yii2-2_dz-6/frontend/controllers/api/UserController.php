<?php 

namespace frontend\controllers\api;

use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'frontend\controllers\api\models_for_api\UserApi';
    // public $modelClass = 'common\models\User';
}