<?php

namespace app\forms;

use app\models\User;
use yii\base\Model;

class RegisterForm extends Model
{
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';

    public function rules(): array
    {
        return [
            [['username', 'email', 'password', 'confirmPassword'], 'required'],

            ['username', 'string', 'min' => 3, 'max' => 50],
            ['username' , 'unique', 'targetClass' => User::class],

            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class],

            ['password', 'string', 'min' => 8],

            [
                'confirmPassword',
                'compare',
                'compareAttribute' => 'password'
            ],
        ];
    }

        public function attributeLabels(): array
    {
        return [

            'username' => 'Username',

            'email' => 'Email',

            'password' => 'Password',

            'confirmPassword' => 'Confirm Password',

        ];
    }
}
