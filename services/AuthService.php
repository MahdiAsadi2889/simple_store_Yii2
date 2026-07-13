<?php

namespace app\services;

use app\components\ApiResponse;
use app\forms\LoginForm;
use app\forms\RegisterForm;
use app\models\RefreshToken;
use app\models\User;
use Yii;
use yii\db\Exception;

class AuthService
{
    public function __construct(private readonly JwtService $jwtService)
    {

    }

    public function register(RegisterForm $form)
    {
        if (!$form->validate()) {
            return [
                'success' => false,
                'errors' => $form->errors,
                'message' => 'Validation failed',
            ];
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
            return [
                'success' => false,
                'errors' => $form->errors,
                'message' => 'Registration failed',
            ];
        }
        $tokens = $this->issueToken($user);
        return [
            'success' => true,
            'message' => 'Registration Successful',
        ];
    }

    public function login(LoginForm $form): ?array
    {
        if (!$form->validate()) {
            return null;
        }

        $user = User::findByLogin($form->login);

        if ($user === null) {
            return null;
        }

        if (!$user->validatePassword($form->password)) {
            return null;
        }

        $user->last_login_at = time();
        $user->save(false);

        return $this->issueToken($user);
    }

    private function issueToken(User $user): array
    {
        $accessToken = $this->jwtService->generate($user);
        $refreshToken = $this->createRefreshToken($user);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ];
    }

    /**
     * @throws Exception
     * @throws \yii\base\Exception
     */
    private function createRefreshToken(User $user): string
    {
        $selector = bin2hex(random_bytes(16));
        $secret = bin2hex(random_bytes(32));
        $refreshToken = new RefreshToken();
        $refreshToken->user_id = $user->id;
        $refreshToken->selector = $selector;
        $refreshToken->token_hash = Yii::$app->security->generatePasswordHash($secret);
        $refreshToken->expires_at = time() + (60 * 60 * 24 * 30);
        $refreshToken->created_at = time();
        $refreshToken->save(false);

        return $selector . '.' . $secret;
    }
}
