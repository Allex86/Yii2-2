<?php

use yii\helpers\Html;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
// /* @var $form yii\widgets\ActiveForm */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="user-form">

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

    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList(\common\models\User::STATUSES) ?>
    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'avatar')->fileInput(['accept' => 'image/*'])->label(Html::img($model->getThumbUploadUrl('avatar', \common\models\User::AVATAR_THUMB))) ?>

    <div class="form-group row">
        <div class="col-sm-offset-2">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
