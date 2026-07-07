<?php

namespace app\commands;

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

        $productUpdate = $auth->createPermission('product.update');
        $productUpdate->description = 'Update Products';
        $auth->add($productUpdate);

        $productDelete = $auth->createPermission('product.delete');
        $productDelete->description = 'Delete Products';
        $auth->add($productDelete);

        $this->stdout("RBAC initialized successfully.\n");
    }
}