<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class TestController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $test = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.';
        $hw = 'Hello, world!';

        return $this->render('index', [
            'test' => $test,
            'hw' => $hw,
        ]);
    }
}
