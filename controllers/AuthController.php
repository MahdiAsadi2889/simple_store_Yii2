<?php

namespace app\controllers;

use app\forms\LoginForm;
use app\forms\RegisterForm;
use app\services\AuthService;
use Yii;
use yii\web\Cookie;

class AuthController extends BaseController
{
    public function __construct(
        $id,
        $module,
        private readonly AuthService $authService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        unset($behaviors['jwtAuth']);

        return $behaviors;
    }

    public function actionRegister()
    {
        $form = new RegisterForm();

        if ($form->load(Yii::$app->request->post())) {

            $result = $this->authService->register($form);

            if ($result['success']) {
                Yii::$app->session->setFlash('success', 'Registration complete successfully');
            }
            return $this->redirect(['login']);
        }

        return $this->render('register', [
            'model' => $form,
        ]);
    }


    public function actionLogin()
    {
        $form = new LoginForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $tokens = $this->authService->login($form);

            if ($tokens !== null) {

                $this->setAccessTokenCookie($tokens['access_token']);
                $this->setRefreshTokenCookie($tokens['refresh_token']);

                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Invalid username/email or password.!');
        }
        return $this->render('login', [
            'model' => $form,
        ]);
    }

    public function actionLogout()
    {
        $refreshToken = Yii::$app->request->cookies->getValue('refresh_token');
        if ($refreshToken !== null) {
            $this->authService->logout($refreshToken);
        }
        Yii::$app->user->logout(false);
        Yii::$app->response->cookies->remove('access_token');
        Yii::$app->response->cookies->remove('refresh_token');

        Yii::$app->session->setFlash('success', 'Logged out successfully.');

        return $this->redirect(['site/index']);
    }

    private function setAccessTokenCookie(string $accessToken): void
    {
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'access_token',
            'value' => $accessToken,
            'httpOnly' => true,
            'sameSite' => Cookie::SAME_SITE_LAX,
            'secure' => YII_ENV_PROD,
            'expire' => time() + 3600
        ]));
    }

    private function setRefreshTokenCookie(string $refreshToken): void
    {
        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'refresh_token',
            'value' => $refreshToken,
            'httpOnly' => true,
            'sameSite' => Cookie::SAME_SITE_LAX,
            'secure' => YII_ENV_PROD,
            'expire' => time() + (60 * 60 * 24 * 30),
        ]));
    }
}
