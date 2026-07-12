<?php

namespace app\forms;

use Override;
use yii\base\Model;

class LoginForm extends Model
{
    public string $login = '';
    public string $password = '';

    public function rules(): array
    {
        return [
            [['login', 'password'], 'required'],
            ['login', 'string', 'min' => 3, 'max' => 255],
            ['password', 'string', 'min' => 8],
        ];
    }

    #[Override]
    public function attributeLabels(): array
    {
        return [
            'login' => 'Username or Password',
            'password' => 'Password'
        ];
    }
}
