<?php
namespace frontend\controllers\api\models_for_api;

use common\models\User;

class UserApi extends User
{
	public function fields()
	{
	    return [
	        'id',
	        'name' => 'username',
	        'email',
	        'status',
	    ];
	}

	public function extraFields()
	{
	    // return ['profile'];
	    return null;
	}
}