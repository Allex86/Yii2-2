<?php

use yii\db\Migration;

/**
 * Handles adding project_id to table `task`.
 * Has foreign keys to the tables:
 *
 * - `project`
 */
class m180903_060437_add_project_id_column_to_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('task', 'project_id', $this->integer()->notNull()->after('estimation'));

        // creates index for column `project_id`
        $this->createIndex(
            'idx-task-project_id',
            'task',
            'project_id'
        );

        // add foreign key for table `project`
        $this->addForeignKey(
            'fk-task-project_id',
            'task',
            'project_id',
            'project',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `project`
        $this->dropForeignKey(
            'fk-task-project_id',
            'task'
        );

        // drops index for column `project_id`
        $this->dropIndex(
            'idx-task-project_id',
            'task'
        );

        $this->dropColumn('task', 'project_id');
    }
}
