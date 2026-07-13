<?php

namespace app\controllers;

use app\forms\LoginForm;
use app\forms\RegisterForm;
use app\services\AuthService;
use Yii;

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


    public function actionRegister()
    {
        $form = new RegisterForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {

            $result = $this->authService->register($form);

            if ($result['success']) {
                return $this->redirect(['login']);
            }
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

                Yii::$app->session->set(
                    'access_token',
                    $tokens['access_token']
                );

                dd($tokens);
            }
            Yii::$app->session->setFlash('error', 'Invalid username/email or password.!');
        }
        return $this->render('login', [
            'model' => $form,
        ]);
    }
}
