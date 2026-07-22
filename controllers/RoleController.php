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

    public function actionIndex()
    {
        $dataProvider = $this->roleService->getDataProvider();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView(int $id)
    {
        $role = $this->roleService->findById($id);

        return $this->render('view', ['role' => $role]);
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

    public function actionUpdate(int $id)
    {
        $model = $this->roleService->findById($id);
        if ($this->request->isPost) {
            $model->load($this->request->post());
            if ($this->roleService->updateRole($model)) {
                return $this->redirect([
                    'view',
                    'id' => $model->id
                ]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
