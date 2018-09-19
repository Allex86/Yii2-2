<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;

use yii\filters\VerbFilter;

/**
 * Site controller
 */
class TestController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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
