<?php 

namespace frontend\controllers\api;

use yii\rest\Controller;
use frontend\controllers\api\models_for_api\ProjectApi;
//use common\models\Project;

class ProjectController extends Controller
{
	// public $modelClass = 'common\models\Project';
   //public $modelClass = 'frontend\controllers\api\models_for_api\ProjectApi';
   
   public function actionsIndex()
   {
   	//$dp = new ActiveDataProvider (['query' => ProjectApi::find()]);
   	//$dp->pagination->padeSize = 2;
   	//return $dp;
   	return new ActiveDataProvider (['query' => ProjectApi::find()]);
   }

   public function actionsView($id_project)
   {
   	// $dp = new ActiveDataProvider (['query' => ProjectApi::findOne($id_project)]);
   	return new ActiveDataProvider (['query' => ProjectApi::findOne($id_project)]);
   }
   
}