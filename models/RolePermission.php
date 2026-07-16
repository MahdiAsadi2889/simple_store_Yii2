<?php

namespace app\models;

use yii\db\ActiveRecord;

class RolePermission extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%role_permission}}';
    }

    public function rules(): array
    {
        return [
            [['role_id', 'permission'], 'required'],
            [['role_id'], 'integer'],
            [['permission'], 'string', 'max' => 100],
        ];
    }

    public function getRole()
    {
        return $this->hasOne(Role::class, ['id'=> 'role_id']);
    }
}
