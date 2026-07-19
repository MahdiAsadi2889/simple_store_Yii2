<?php

namespace app\controllers;

use app\models\Role;
use app\models\User;
use app\services\RoleService;

class RoleController extends BaseController
{
    public function __construct($id, $module, private readonly RoleService $roleService, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionCreate()
    {
        $model = new Role();

        if ($this->request->isPost) {
            $model->load($this->request->post());
            if ($this->roleService->createRole($model)) {
                return $this->redirect([
                    'view',
                    'id' => $model->id
                ]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionTestAssign()
    {
        $user = User::findOne(1);
        $role = Role::findOne(1);

        if ($this->roleService->assignRoleToUser($user, $role)) {
            return 'Role assigned successfully';
        }
        return 'Role already assigned or failed';
    }

    public function actionRemoveAssign()
    {
        $user = User::findOne(1);
        $role = Role::findOne(1);

        if ($this->roleService->removeRoleFromUser($user, $role)) {
            return 'Role removed successfully';
        }
        return 'Role remove failed';
    }
}
