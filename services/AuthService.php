<?php

namespace app\services;

use app\components\ApiResponse;
use app\forms\LoginForm;
use app\forms\RegisterForm;
use app\models\User;
use Yii;

class AuthService
{
    public function __construct(private readonly JwtService $jwtService)
    {

    }

    public function register(RegisterForm $form)
    {
        if (!$form->validate()) {
            return ApiResponse::error('Validation Failed', $form->errors);
        }
        $user = new User();
        $user->username = $form->username;
        $user->email = $form->email;
        $user->setPassword($form->password);
        $user->generateAuthKey();

        $user->status = User::STATUS_ACTIVE;
        $user->created_at = time();
        $user->updated_at = time();

        if (!$user->save()) {
            return ApiResponse::error('Registration Failed', $user->errors);
        }
        $tokens = $this->issueToken($user);
        return ApiResponse::success($tokens, 'Registration Successful');
    }

    public function login(LoginForm $form)
    {
        if (!$form->validate()) {
            return ApiResponse::error('Validation Failed', $form->errors);
        }

        $user = User::findByLogin($form->login);
        if ($user === null) {
            return ApiResponse::error('Invalid Credentials');
        }
        if (!$user->validatePassword($form->password)) {
            return ApiResponse::error('Invalid Credentials');
        }
        $user->last_login_at = time();
        $user->save(false);

        $tokens = $this->issueToken($user);

        return ApiResponse::success($tokens, 'Login Successful');

    }

    private function issueToken(User $user): array
    {
        $accessToken = $this->jwtService->generate($user);

        return [
            'access_token' => $accessToken,
        ];
    }
}
