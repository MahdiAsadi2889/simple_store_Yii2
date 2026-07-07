<?php

namespace app\commands;

use Yii;
use yii\console\Controller;

class TestController extends Controller
{
    public function actionRedis()
    {
        Yii::$app->redis->set('test','hello redis');
        echo Yii::$app->redis->get('test') . PHP_EOL;
    }
}