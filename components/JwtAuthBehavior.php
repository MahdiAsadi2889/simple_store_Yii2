<?php

namespace app\components;

use app\models\User;
use app\services\JwtService;
use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\di\NotInstantiableException;
use yii\web\Controller;
use Yii;

class JwtAuthBehavior extends Behavior
{
    private JwtService $jwtService;

    /**
     * @throws NotInstantiableException
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        parent::init();
        $this->jwtService = Yii::$container->get(JwtService::class);
    }

    public function events(): array
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    public function beforeAction($event): bool
    {
        $token = Yii::$app->request->cookies->getValue('access_token');

        if (!$token) {
            return true;
        }

        if (!$this->jwtService->validate($token)) {

            return true;
        }

        $payload = $this->jwtService->getPayload($token);

        $userId = $payload['sub'] ?? null;

        if (!$userId) {
            return true;
        }

        $user = User::findOne($userId);

        if ($user !== null) {
            Yii::$app->user->login($user, 0);
        }

        return true;
    }

}
