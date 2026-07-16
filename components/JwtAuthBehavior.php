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
        $user = $this->jwtService->getUser($token);
        if ($user === null) {
            return true;
        }

        if (Yii::$app->user->isGuest || Yii::$app->user->id != $user->id) {
            Yii::$app->user->switchIdentity($user, 0);
        }
        return true;
    }

}
