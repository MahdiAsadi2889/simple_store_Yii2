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
        if (User::find()->where(['username' => 'admin'])->exists()) {
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

        if ($user->save()) {
            $this->stdout("Admin user Created Successfully.\n");
        } else {
            print_r($user->errors);
        }
    }

    private function seedProducts()
    {
        $products = [
            [
                'title' => 'Samsung Galaxy S25 FE',
                'description' => 'Samsung smartphone',
                'price' => 120000000,
            ],
            [
                'title' => 'iPhone 17',
                'description' => 'Apple smartphone',
                'price' => 70000000,
            ],
            [
                'title' => 'Xiaomi 15',
                'description' => 'Xiaomi smartphone',
                'price' => 30000000,
            ]
        ];

        foreach ($products as $data) {
            $exists = Product::find()
                ->where(['title' => $data['title']])
                ->exists();

            if ($exists) {
                continue;
            }
            $product = new Product();
            $product->title = $data['title'];
            $product->description = $data['description'];
            $product->price = $data['price'];
            $product->created_at = time();
            $product->updated_at = time();

            if (!$product->save()) {
                print_r($product->errors);
            }
        }
        $this->stdout("Products seeded successfully.\n");
    }
}
