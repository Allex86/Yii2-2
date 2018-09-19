<?php

namespace frontend\modules\api\controllers;

// use yii\rest\ActiveController;

use yii\rest\Controller;
use frontend\modules\api\models\ProjectApi;
use yii\data\ActiveDataProvider;

use yii\filters\auth\HttpBasicAuth;

class ProjectController extends Controller
{
    public $modelClass = 'frontend\modules\api\models\ProjectApi';

    // public function behaviors()
    // {
    //     $behaviors = parent::behaviors();
    //     $behaviors['authenticator'] = ['class' => HttpBasicAuth::className(),];
    //     return $behaviors;
    // }
   
    public function actionIndex()
    {
         // return new ActiveDataProvider([
         //    'query' => ProjectApi::find(),
         //    'pagination' => ['pageSize' => 2,]
         // ]);
         $dp = new ActiveDataProvider(['query' => ProjectApi::find()]);
         // $dp->pagination->pageSize = 2;
         return $dp;
    }

    public function actionView($id_project)
    {
        return ProjectApi::findOne($id_project);
    }
}
