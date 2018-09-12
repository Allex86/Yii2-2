<?php
namespace frontend\controllers\api\models_for_api;

use common\models\Project;

class ProjectApi extends Project
{
	public function fields()
	{
	    return ['id', 'title'];
	}

	public function extraFields()
	{
	    // return ['profile'];
	    return null;
	}
}