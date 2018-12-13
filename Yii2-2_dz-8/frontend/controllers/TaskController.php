<?php

namespace frontend\controllers;

use Yii;
use common\models\Task;
use common\models\search\TaskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    Yii::$app->session->setFlash('info', 'Access denied!');
                    $this->redirect(['/site/login']);
                },
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        /** @var $query TaskQuery */
        $query = $dataProvider->query;
        $query->byUser(Yii::$app->user->id);

        $filterUserActive = \common\models\User::find()
            ->select('username')
            ->onlyActive()
            ->indexBy('id')
            ->column();

        $filterProjectTitle = \common\models\Project::find()
            ->select('title')
            ->indexBy('id')
            ->column();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'filterProjectTitle' => $filterProjectTitle,
            'filterUserActive' => $filterUserActive,
        ]);
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', 'Created');

            return $this->redirect(['view', 'id' => $model->id]);
        }

            // if ($model->load(Yii::$app->request->post()) && !$model->validate())
            // {
            //  foreach ($model->getErrors() as $key => $value) {
            //      echo $key.': '.$value[0];
            //  }
            //  return;
            // }

        $projects = \common\models\Project::find()
        ->byUser(Yii::$app->user->id, \common\models\ProjectUser::ROLE_MANAGER)
        ->select('title')
        ->indexBy('id')
        ->column();

        return $this->render('create', [
            'model' => $model,
            'projects' => $projects,
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('info', 'Updated');
            
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash('info', 'Deleted');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionTake($id)
    {
        $model = $this->findModel($id);
        
        if (Yii::$app->taskService->takeTask($model, Yii::$app->user->identity)) {
            Yii::$app->session->setFlash('info', 'Take');
        } else {
            Yii::$app->session->setFlash('info', 'Houston, we have a problem!');
        }

        return $this->redirect(['index']);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionComplete($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->taskService->completeTask($model, Yii::$app->user->identity)) {
            Yii::$app->session->setFlash('info', 'Complete');
        } else {
            Yii::$app->session->setFlash('info', 'Houston, we have a problem!');
        }

        return $this->redirect(['index']);
    }
}
