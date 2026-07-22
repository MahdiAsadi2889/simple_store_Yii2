<?php

namespace app\services;

use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class UserService
{
    public function getDataProvider(): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => User::find(),
        ]);
    }

    public function getUserById(int $userId): User
    {
        $user = User::findOne($userId);
        if ($user === null) {
            throw new NotFoundHttpException('User not found');
        }
        return $user;
    }

    public function updateUser(User $user): bool
    {
        if (!$user->validate()) {
            return false;
        }

        return $user->save(false);
    }
}
