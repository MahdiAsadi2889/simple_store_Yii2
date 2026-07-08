<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class BaseController extends Controller
{
    protected function checkAccess(string $permission):void
    {
        if(!Yii::$app->user->can($permission)){
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
    }
}