<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

use yii\validators\UniqueValidator;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property string $avatar
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @mixin UploadImageBehavior
 */
class User extends ActiveRecord implements IdentityInterface
{
    private $_password;
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const SCENARIO_ADMIN_CREATE = 'admin_create';
    const SCENARIO_ADMIN_UPDATE = 'admin_update';
    const SCENARIO_USER_UPDATE = 'user_update';

	 const STATUSES = [
	 	self::STATUS_DELETED => 'удалён',
    	self::STATUS_ACTIVE => 'активен'
	 ];

	 const AVATAR_THUMB = 'thumb';
	 const AVATAR_PREVIEW = 'preview';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $host = Yii::$app->params['frontend_scheme'].Yii::$app->params['frontend_domain'];
        return [
            TimestampBehavior::className(),
            [
                'class' => \mohorev\file\UploadImageBehavior::class,
                'attribute' => 'avatar',
                'scenarios' => [self::SCENARIO_ADMIN_CREATE, self::SCENARIO_ADMIN_UPDATE], // ['insert', 'update'],
                // 'placeholder' => '@app/modules/user/assets/images/userpic.jpg',
                'placeholder' => '@frontend/web/upload/avatar/userpic.jpg',
                'path' => '@frontend/web/upload/avatar/{id}',
                'url' => $host.'/upload/avatar/{id}',
                'thumbs' => [
                    self::AVATAR_PREVIEW => ['width' => 300, 'quality' => 90], // 400
                    self::AVATAR_THUMB => ['width' => 50, 'height' => 50],
                    // 'news_thumb' => ['width' => 200, 'height' => 200, 'bg_color' => '000'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

            ['username', UniqueValidator::className(), 'on' => [self::SCENARIO_ADMIN_CREATE, self::SCENARIO_ADMIN_UPDATE, self::SCENARIO_USER_UPDATE]],
            [['avatar'], 'file', 
            	'extensions' => ['jpg', 'jpeg', 'png'],
            	'minSize' => 1000,
            	'maxSize' => 10000000,
            ],
            	 //, 'on' => ['insert', 'update']],
            ['password', 'string', 'min' => 6],
            ['email', 'email', 'on' => [self::SCENARIO_ADMIN_CREATE, self::SCENARIO_ADMIN_UPDATE]],
            [['username', 'email', 'password'], 'required', 'on' => self::SCENARIO_ADMIN_CREATE],
            [['username', 'email', 'password'], 'required', 'on' => self::SCENARIO_ADMIN_UPDATE],
            [['username'], 'required', 'on' => self::SCENARIO_USER_UPDATE]
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if ($insert) {
            $this->generateAuthKey();
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }


    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        if ($password)
        {
            $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        }
        
        // $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        $this->_password = $password;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getAvatar()
    {
        return $this->getThumbUploadUrl('avatar', \common\models\User::AVATAR_THUMB);
    }
    
    public function getUsername()
    {
        return $this->username. ' #'.$this->id;
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\UserQuery(get_called_class());
    }
}
