<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class RefreshToken extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%refresh_token}}';
    }

    public function rules(): array
    {
        return [
            [['user_id', 'expired_at', 'created_at', 'revoked_at'], 'integer'],
            [['token_hash'], 'string'],
            [['user_id', 'expired_at', 'created_at', 'revoked_at'], 'required'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'token_hash' => 'Token Hash',
            'expired_at' => 'Expired At',
            'created_at' => 'Created At',
            'revoked_at' => 'Revoked At',
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
