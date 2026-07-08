<?php

namespace app\commands;

use app\models\User;
use yii\console\Controller;
use Yii;
use yii\rbac\Role;
use yii\rbac\Permission;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // حذف اطلاعات قبلی 
        $auth->removeAll();

        // ساخت Role ها 
        $admin = $auth->createRole('admin');
        $auth->add($admin);

        $customer = $auth->createRole('customer');
        $auth->add($customer);

        // ساخت Persmission ها 
        $productView = $auth->createPermission('product/view');
        $productView->description = 'View Products';
        $auth->add($productView);

        $productCreate = $auth->createPermission('product/create');
        $productCreate->description = 'Create Products';
        $auth->add($productCreate);

        $productUpdate = $auth->createPermission('product/update');
        $productUpdate->description = 'Update Products';
        $auth->add($productUpdate);

        $productDelete = $auth->createPermission('product/delete');
        $productDelete->description = 'Delete Products';
        $auth->add($productDelete);
        // پایان ساخت Permission ها

        // ارتباط والد با فرزند 
        $auth->addChild($admin, $productView);
        $auth->addChild($admin, $productCreate);
        $auth->addChild($admin, $productUpdate);
        $auth->addChild($admin, $productDelete);

        $auth->addChild($customer, $productView);

        // پایان ارتباط والد با فرزند

        $user = User::findOne(['username' => 'admin']);

        if($user !== null){
            $auth->assign($admin, $user->id);
        }

        $this->stdout("RBAC initialized successfully.\n");
    }
}