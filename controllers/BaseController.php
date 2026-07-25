<?php

namespace app\controllers;

use app\components\JwtAuthBehavior;
use app\services\RbacService;
use Yii;
use yii\base\InvalidConfigException;
use yii\di\NotInstantiableException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\UnauthorizedHttpException;

class BaseController extends Controller
{
    public function behaviors(): array
    {
        return [

            'jwtAuth' => [
                'class' => JwtAuthBehavior::class
            ],

            'access' => [
                'class' => AccessControl::class,

                'rules' => [
                    [
                        'allow' => true,

                        'matchCallback' => function ($rule, $action) {

                            $permissions = $this->permissions();

                            if (!isset($permissions[$action->id])) {
                                return true;
                            }

                            $this->checkAccess(
                                $permissions[$action->id]
                            );

                            return true;
                        },
                    ],
                ],
            ],

        ];
    }


    public function permissions(): array
    {
        return [];
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
            throw new UnauthorizedHttpException('Login is required.');
        }

        if (!$this->getRbacService()->can($userId, $permission)) {
            throw new ForbiddenHttpException('Access denied');
        }
    }
}
