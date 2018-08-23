<?php
namespace console\controllers;

use yii\console\Controller;

/**
 * Site controller
 */
class ConsoleGreatingsController extends Controller
{
    /**
     * Say Hello =)
     *
     */
    public function actionIndex()
    {
        echo 'Hello, world!';
    }
}
