<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=  GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // 'project_id',
            [
                'label' => 'Project',
                'attribute' => 'project_id',
                'format' => 'html',
                'filter' => $filterProjectTitle,
                'value' => function ($model) {
                    return Html::a($model->project->title, ['project/view', 'id' => $model->project->id]);
                }
            ],
            'title',
            'description:ntext',
            'estimation',
            // 'executor.username',
            ['attribute' => 'executor_id',
                // 'label' => 'Executor',
                'filter' => $filterUserActive,
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->executor) {
                        return Html::a($model->executor->username, ['user/view', 'id' => $model->executor->id]);
                    }
                }
            ],
            'started_at:datetime',
            'completed_at:datetime',
            // 'created_by',
            [
                'attribute' => 'created_by',
                'format' => 'html',
                'filter' => $filterUserActive,
                'value' => function ($model) {
                    return Html::a($model->creator->username, ['user/view', 'id' => $model->creator->id]);
                }
            ],
            // 'updated_by',
            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {take} {complete} {update} {delete}',
                'buttons' => [
                    'take' => function ($url, \common\models\Task $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('cloud-download');
                        return Html::a($icon, ['task/take', 'id' => $model->id], ['data' => [
                            'confirm' => 'Взять задачу?',
                            'method' => 'post',
                            ]]);
                    },
                    'complete' => function ($url, \common\models\Task $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('cloud-upload');
                        return Html::a($icon, ['task/complete', 'id' => $model->id], ['data' => [
                            'confirm' => 'Завершить задачу?',
                            'method' => 'post',
                            ]]);
                    },
                ],
                'visibleButtons' => [
                    'take' => function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->taskService->canTake($model, Yii::$app->user->identity);
                    },
                    'complete' => function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->taskService->canCompele($model, Yii::$app->user->identity);
                    },
                    'update' => function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->taskService->canManage($model->project, Yii::$app->user->identity);
                    },
                    'delete' => function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->taskService->canManage($model->project, Yii::$app->user->identity);
                    },
                ]
                ],
            ],
        ]); ?>

    <?php Pjax::end(); ?>
</div>
