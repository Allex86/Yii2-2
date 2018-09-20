<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TasktSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--<p>
        <?= null // Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            'id',
            // 'project_id',
            [
                'label' => 'Project',
                'attribute' => 'project_id',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a($model->project->title, ['project/view', 'id' => $model->project->id]);
                }
            ],
            'title',
            'description:ntext',
            'estimation',
            'executor_id',
            'started_at:datetime',
            'completed_at:datetime',
            'created_by',
            'updated_by',
            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
