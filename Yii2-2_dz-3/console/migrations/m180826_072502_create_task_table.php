<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task`.
 */
class m180826_072502_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'estimation' => $this->integer()->notNull(),
            'executor_id' => $this->integer(),
            'started_at' => $this->integer(),
            'completed_at' => $this->integer(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-task-executor_id',
            'task',
            'executor_id',
            'user',
            'id'
        );

        $this->addForeignKey(
            'fk-task-created_by',
            'task',
            'created_by',
            'user',
            'id'
        );

        $this->addForeignKey(
            'fk-task-updated_by',
            'task',
            'updated_by',
            'user',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('task');
    }
}
