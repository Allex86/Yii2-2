<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--<p>
        <?= null // Html::a('Create Project', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a($model->title, ['view', 'id' => $model->id]);
                }
            ],
            [
                'attribute' => common\models\Project::RELATION_PROJECT_USERS.'role',
                'format' => 'html',
                'value' => function ($model) {
                    return join(',', Yii::$app->projectService->getRoles($model, Yii::$app->user->identity));
                }
            ],
            'description:ntext',
            // 'created_by',
            [
                'attribute' => 'created_by',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a($model->creator->username, ['user/view', 'id' => $model->creator->id]);
                }
            ],
            // 'updated_by',
            [
                'attribute' => 'updated_by',
                'format' => 'html',
                'value' => function ($model) {
                    return Html::a($model->updater->username, ['user/view', 'id' => $model->updater->id]);
                }
            ],
            // 'created_at:datetime',
            // 'updated_at:datetime',
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
