<?php

namespace app\controllers;

use app\components\JwtAuthBehavior;
use Yii;
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
    protected function checkAccess(string $permission):void
    {
        if(!Yii::$app->user->can($permission)){
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
    }
}
