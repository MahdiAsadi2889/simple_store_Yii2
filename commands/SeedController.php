<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Product;
use app\models\User;
use Yii;

class SeedController extends Controller
{
    public function actionInit() 
    {
        $this->seedUsers();
        $this->seedProducts();

        $this->stdout("Seed completed successfully.\n");
    }

    private function seedUsers()
    {
        if(User::find()->where(['username' => 'admin'])->exists()){
            $this->stdout('Admin user Already Exists. \n');
            return;
        }

        $user = new User();
        $user->username = 'admin';
        $user->password_hash = Yii::$app->security->generatePasswordHash('admin');
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->status = 10;
        $user->created_at = time();
        $user->updated_at = time();

        if($user->save()){
            $this->stdout('Admin user Created Successfully.\n');
        }else{
            print_r($user->errors);
        }
    }

    private function seedProducts()
    {
        
    }
}