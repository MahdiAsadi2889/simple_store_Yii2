<?php

namespace app\controllers;

use app\components\JwtAuthBehavior;
use app\services\RbacService;
use Yii;
use yii\base\InvalidConfigException;
use yii\di\NotInstantiableException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class BaseController extends Controller
{

    public function behaviors(): array
    {
        return [
            'jwtAuth' => [
                'class' => JwtAuthBehavior::class
            ]
        ];
    }

    /**
     * @throws NotInstantiableException
     * @throws InvalidConfigException
     */
    protected function getRbacService(): RbacService
    {
        return Yii::$container->get(RbacService::class);
    }

    protected function checkAccess(string $permission): void
    {
        $userId = Yii::$app->user->id;

        if ($userId === null) {
            throw new ForbiddenHttpException('Login is Required');
        }

        if(!$this->getRbacService()->can($userId, $permission)) {
            throw new ForbiddenHttpException('Access denied');
        }
    }
}
