<?php

namespace app\services;

use app\components\ApiResponse;
use app\forms\LoginForm;
use app\forms\RegisterForm;
use app\models\RefreshToken;
use app\models\User;
use RuntimeException;
use Yii;
use yii\db\Exception;

class AuthService
{
    private const REFRESH_TOKEN_TTL = 60 * 60 * 24 * 30;
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

    public function logout(string $refreshToken): void
    {
        if (!str_contains($refreshToken, '.')) {
            return;
        }

        [$selector, $secret] = explode('.', $refreshToken, 2);
        $token = RefreshToken::findOne([
            'selector' => $selector,
        ]);

        if ($token === null) {
            return;
        }
        if ($token->revoked_at !== null) {
            return;
        }

        $this->revokeRefreshToken($token);

        Yii::$app->response->cookies->remove('access_token');
        Yii::$app->response->cookies->remove('refresh_token');

        Yii::$app->user->logout(false);
    }

    public function refresh(string $refreshToken): ?array
    {
        if (!str_contains($refreshToken, '.')) {
            return null;
        }

        [$selector, $secret] = explode('.', $refreshToken, 2);
        $refreshToken = $this->findValidateRefreshToken($selector);

        if ($refreshToken === null) {
            return null;
        }

        if (!$this->verifyRefreshToken($secret, $refreshToken)) {
            return null;
        }

        $user = User::findOne($refreshToken->user_id);

        if ($user === null) {
            throw new RuntimeException('Refresh token references non-existing user');
        }

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
        $refreshToken->expires_at = time() + self::REFRESH_TOKEN_TTL;
        $refreshToken->created_at = time();
        if (!$refreshToken->save(false)) {
            throw new RuntimeException('Failed to create refresh token.');
        }

        return $selector . '.' . $secret;
    }

    private function revokeRefreshToken(RefreshToken $refreshToken): void
    {
        $refreshToken->revoked_at = time();

        if (!$refreshToken->save(false)) {
            throw new RuntimeException('Failed to revoke refresh token.');
        }
    }

    private function findValidateRefreshToken(string $selector): ?RefreshToken
    {
        $token = RefreshToken::findOne([
            'selector' => $selector,
        ]);
        if ($token === null) {
            return null;
        }
        if ($token->revoked_at !== null) {
            return null;
        }
        if ($token->expires_at < time()) {
            return null;
        }

        return $token;
    }

    private function verifyRefreshToken(string $secret, RefreshToken $refreshToken): bool
    {
        return Yii::$app->security->validatePassword($secret, $refreshToken->token_hash);
    }


}
