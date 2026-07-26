<?php

namespace app\controllers;

use Yii;
use app\models\Role;
use app\services\RoleService;
use yii\web\NotFoundHttpException;

class RoleController extends BaseController
{
    public function __construct($id, $module, private readonly RoleService $roleService, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function permissions(): array
    {
        return [

            'index' => 'role/view',
            'view' => 'role/view',
            'create' => 'role/create',
            'update' => 'role/update',
            'delete' => 'role/delete',

        ];
    }

    public function actionIndex()
    {
        $dataProvider = $this->roleService->getDataProvider();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $role = Role::findOne($id);

        if ($role === null) {
            throw new NotFoundHttpException('Role not found');
        }

        return $this->render('view', [
            'role' => $role,
            'users' => $this->roleService->getRoleUsers($role),
            'permissions' => $this->roleService->getRolePermissions($role),
        ]);
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

    public function actionDelete(int $id)
    {
        $role = $this->roleService->findById($id);

        $result = $this->roleService->deleteRole($role);

        Yii::$app->session->setFlash($result ? 'success' : 'error', $result ? 'Role Deleted Successfully' : 'Failed to delete role.');

        return $this->redirect(['index']);
    }
}
