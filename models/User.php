<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */


class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

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
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 10],
            [['username', 'password_hash', 'auth_key', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['password_hash', 'auth_key'], 'string', 'max' => 255],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function findByUsername(string $username): ?self
    {
        return static::findOne(['username' => $username]);
    }

    public static function findIdentity($id): ?IdentityInterface
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        return null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }
}
