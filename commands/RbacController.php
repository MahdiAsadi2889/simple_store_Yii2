<?php

namespace app\commands;

use app\models\User;
use yii\console\Controller;
use Yii;
use yii\rbac\Role;
use yii\rbac\Permission;

class RbacController extends Controller
{
    public function actionInit($reset = false)
    {
        $auth = Yii::$app->authManager;
        if ($reset) {
            $auth->removeAll();
        }

        // ساخت Role ها 
        $admin = $this->createRole('admin');
        $customer = $this->createRole('customer');

        // ساخت Persmission ها 
        $productView = $this->createPermission('product/view', 'View Products');

        $productCreate = $this->createPermission('product/create', 'Create Product');

        $productUpdate = $this->createPermission('product/update', 'Update Product');

        $productDelete = $this->createPermission('product/delete', 'Delete Product');

        $rbacManage = $this->createPermission('rbac/manage','Manage Roles and Permissions');
        // پایان ساخت Permission ها 

        // ارتباط والد با فرزند 
        $auth->addChild($admin, $productView);
        $auth->addChild($admin, $productCreate);
        $auth->addChild($admin, $productUpdate);
        $auth->addChild($admin, $productDelete);

        $auth->addChild($customer, $productView);

        $auth->addChild($admin, $rbacManage);

        // پایان ارتباط والد با فرزند

        $user = User::findOne(['username' => 'admin']);

        if ($user !== null) {
            $auth->assign($admin, $user->id);
        }

        $this->stdout("RBAC initialized successfully.\n");
    }

    private function createRole(string $name): Role
    {
        $auth = Yii::$app->authManager;

        $role = $auth->getRole($name);

        if ($role === null) {
            $role = $auth->createRole($name);
            $auth->add($role);
        }

        return $role;
    }

    private function createPermission(string $name, string $description): Permission
    {
        $auth = Yii::$app->authManager;
        $permission = $auth->getPermission($name);
        if ($permission === null) {
            $permission = $auth->createPermission($name);
            $permission->description = $description;
            $auth->add($permission);
        }

        return $permission;
    }
}
