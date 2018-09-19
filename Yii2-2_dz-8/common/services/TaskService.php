<?php

namespace common\services;

use common\models\ProjectUser;
use common\models\Project;
use common\models\User;
use yii\base\Event;
use Yii;

class TaskService extends \yii\base\Component
{
    
    public function canManage(Project $project, User $user)
    {
        # Проверяющий может ли пользователь управлять задачами в проекте - может если менеджер в проекте, используйте hasRole() из Project сервиса
        if (Yii::$app->projectService->hasRole($project, $user, ProjectUser::ROLE_MANAGER)) {
            return true;
        }
        return false;
    }

    public function canTake(Task $task, User $user)
    {
        # Проверяющий может ли пользователь взять задачу в работу - может если деверолер в проекте, используйте hasRole() из Project сервиса, и поле executor_id у задачи пустое.
        
        if (Yii::$app->projectService->hasRole($task->project_id, Yii::$app->user->id, ProjectUser::ROLE_DEVELOPER) && empty($task->executor_id)) {
            return true;
        }
        return false;
    }

    public function canCompele(Task $task, User $user)
    {
        # Проверяющий может ли пользователь закончить работу - может если пользователь в поле executor_id у задачи.
        
        if (Yii::$app->user->id === $task->executor_id) {
            return true;
        }
        return false;
    }

    public function takeTask(Task $task, User $user)
    {
        # взять задачу в работу - изменяем start_at и executor_id
         
        $task->executor_id = $user->id;
        $task->start_at = time();
        return $task->save();
    }

    public function completeTask(Task $task, User $user)
    {
        # закончить работу - изменяем completed_at

        $task->completed_at = time();
        return $task->save();
    }
}
