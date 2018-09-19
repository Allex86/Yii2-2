<?php

namespace common\models;

use Yii;

use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;


/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property boolean $active
 * @property int $creator
 * @property int $updater
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property ProjectUser[] $projectUsers
 */
class Project extends \yii\db\ActiveRecord
{
    const RELATION_PROJECT_USERS = 'projectUsers';
     const STATUS_ACTIVE = 1;
     const STATUS_NOT_ACTIVE = 0;

     const STATUSES = [
        self::STATUS_ACTIVE => 'активен',
        self::STATUS_NOT_ACTIVE => 'неактивен'
     ];
    

     public function behaviors()
     {
         return [
            ['class' => TimestampBehavior::className()],
            ['class' => BlameableBehavior::className()],
            'saveRelations' => [
                // https://github.com/la-haute-societe/yii2-save-relations-behavior
                'class'     => SaveRelationsBehavior::className(),
                'relations' => [self::RELATION_PROJECT_USERS]
            ],
         ];
        }

    /**
     * {@inheritdoc}
     */
        public static function tableName()
        {
            return 'project';
        }

    /**
     * {@inheritdoc}
     */
        public function rules()
        {
            return [
            [['title', 'description', 'active', /*'created_by', 'created_at'*/], 'required'],
            [['description'], 'string'],
            [['active'], 'boolean'],
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'active'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            ];
        }

    /**
     * {@inheritdoc}
     */
        public function attributeLabels()
        {
            return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'active' => 'Active',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            ];
        }

    /**
     * @return \yii\db\ActiveQuery
     */
        public function getCreator()
        {
            return $this->hasOne(User::className(), ['id' => 'created_by']);
        }

    /**
     * @return \yii\db\ActiveQuery
     */
        public function getUpdater()
        {
            return $this->hasOne(User::className(), ['id' => 'updated_by']);
        }

    /**
     * @return ProjectUserQuery|\yii\db\ActiveQuery
     */
        public function getProjectUsers()
        {
            return $this->hasMany(ProjectUser::className(), ['project_id' => 'id']);
        }

    /**
     * {@inheritdoc}
     * @return \common\models\query\ProjectQuery the active query used by this AR class.
     */
        public static function find()
        {
            return new \common\models\query\ProjectQuery(get_called_class());
        }

        public function getUsersData()
        {
            return $this->getProjectUsers()->select('role')->indexBy('user_id')->column();
        }
}
