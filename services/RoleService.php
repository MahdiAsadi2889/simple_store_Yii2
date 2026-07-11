<?php

namespace app\services;

use app\models\RoleForm;
use DomainException;
use Yii;
use yii\rbac\Role;

class RoleService
{
    public function create(RoleForm $form): Role
    {
        $auth = Yii::$app->authManager;
        if ($auth->getRole($form->name) !== null) {
            throw new DomainException('Role already exists');
        }
        $role = $auth->createRole($form->name);
        $role->description = $form->description;
        $auth->add($role);
        return $role;
    }

    public function getAll(): array
    {
        return Yii::$app->authManager->getRoles();
    }

    public function find(string $name)
    {
        return Yii::$app->authManager->getRole($name);
    }

    public function update(string $name, RoleForm $form)
    {
        $auth = Yii::$app->authManager;

        $role = $auth->getRole($name);
        if ($role === null) {
            throw new DomainException('Role not found.');
        }

        $role->description = $form->description;

        $auth->update($name, $role);

        return $role;
    }

    public function delete(string $name): bool
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);

        if ($role === null) {
            throw new DomainException('Role not found.');
        }


        if ($name === 'admin') {
            throw new DomainException('Admin role cannot be deleted.');
        }

        return $auth->remove($role);
    }
}
