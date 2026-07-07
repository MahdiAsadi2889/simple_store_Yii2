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
        
    }

    private function seedProducts()
    {
        
    }
}