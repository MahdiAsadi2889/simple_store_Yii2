<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class RolePermission extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%role_permission}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
            ],
        ];
    }
    public function rules(): array
    {
        return [
            [['role_id', 'permission'], 'required'],
            [['role_id', 'permission'], 'unique', 'targetAttribute' => ['role_id', 'permission']],
            [['role_id'], 'integer'],
            [['permission'], 'string', 'max' => 100],
        ];
    }

    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }
}
