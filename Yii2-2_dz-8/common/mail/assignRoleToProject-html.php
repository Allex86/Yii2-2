<?php
/* @var $this yii\web\View */
/* @var $project common\models\Project */
/* @var $user common\models\User */
/* @var $role string */
?>

<div>
    <p>Здравствуйте</p>
    <p>В проекте <?= $project->title ?> пользователю <?= $user->username ?> назначена роль <?= $role ?></p>
</div>