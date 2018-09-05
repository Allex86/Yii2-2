<?php
namespace frontend\controllers;

use Yii;
// use yii\base\InvalidArgumentException;
// use yii\web\BadRequestHttpException;
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
//        return $this->render('index');
        $test = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.';
        $hw = 'Hello, world!';

        return $this->render('index', [
            'test' => $test,
            'hw' => $hw,
        ]);
    }
}
