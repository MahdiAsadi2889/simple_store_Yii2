<?php

namespace app\models;

use yii\db\ActiveRecord;

class UserPermission extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%user_permission}}';
    }

    public function rules(): array
    {
        return [
            [['user_id', 'permission'], 'required'],
            [['user_id', 'permission'], 'unique', 'targetAttribute' => ['user_id', 'permission']],
            [['user_id'], 'integer'],
            [['permission'], 'string', 'max' => 100],
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::class, ['id'=> 'user_id']);
    }
}
