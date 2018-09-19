<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

<?php if (Yii::$app->taskService->canManage($model->project, Yii::$app->user->identity)) : ?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?php endif ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            'estimation',
            'executor.username',
            'started_at:datetime',
            'completed_at:datetime',
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
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <?php echo \yii2mod\comments\widgets\Comment::widget([
        'model' => $model,
    ]); ?>

</div>
