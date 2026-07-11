<?php

namespace app\services;

use app\models\RoleForm;
use DomainException;
use Yii;
use yii\rbac\Role;

class RoleServices 
{
    public function create(RoleForm $form): Role
    {
        $auth = Yii::$app->authManager;
        if($auth->getRole($form->name) !== null){
            throw new DomainException('Role already exists');
        }
        $role = $auth->createRole($form->name);
            $role->description = $form->description;
            $auth->add($role);
            return $role;
    }
}
