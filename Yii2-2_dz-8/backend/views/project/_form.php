<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(['layout' => 'horizontal',
       'fieldConfig' => [
           'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
           'horizontalCssClasses' => [
               'label' => 'col-sm-2',
               // 'offset' => 'col-sm-offset-4',
               // 'wrapper' => 'col-sm-8',
               // 'error' => '',
               // 'hint' => '',
           ],
       ],
        'options' => ['enctype' => 'multipart/form-data']
     ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->dropDownList(\common\models\Project::STATUSES) ?>

    <?php if (!$model->isNewRecord) { ?>

    <?= $form->field($model, \common\models\Project::RELATION_PROJECT_USERS)->widget(
        \unclead\multipleinput\MultipleInput::className(),
        // https://github.com/unclead/yii2-multiple-input
        [
        'max'               => 10,
        'min'               => 0, // should be at least 2 rows
        'allowEmptyList'    => false,
        'enableGuessTitle'  => true,
        'addButtonPosition' => \unclead\multipleinput\MultipleInput::POS_HEADER,
        'columns' => [
                [
                'name'  => 'project_id',
                'type'  => 'hiddenInput',
                'defaultValue' => $model->id,
                ],
                [
                'name'  => 'user_id',
                'type'  => 'dropDownList',
                'title' => 'User',
                'items' => \common\models\User::find()->select('username')->indexBy('id')->column()
                ],
                [
                'name'  => 'role',
                'type'  => 'dropDownList',
                'title' => 'Role',
                'items' => \common\models\ProjectUser::ROLES
                ],
        ]
        ]
    ) ?>

    <?php } ?>

    

    <div class="form-group">
        <div class="col-sm-offset-2">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
