<?php

namespace app\controllers;

use app\models\RoleForm;
use app\services\RoleService;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\NotFoundHttpException;

class RoleController extends BaseController
{
    public function actionIndex()
    {
        $roleService = new RoleService();

        $roles = $roleService->getAll();

        $dataProvider = new ArrayDataProvider([
            'allModels' => array_values($roles),
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'attributes' => ['name', 'description']
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionView(string $name)
    {
        $roleService = new RoleService();
        $role = $roleService->find($name);

        if ($role === null) {
            throw new NotFoundHttpException('Role not found.');
        }
        return $this->render('view', [
            'role' => $role,
        ]);
    }
    public function actionCreate()
    {
        $model = new RoleForm();
        $roleService = new RoleService();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $roleService->create($model);
            Yii::$app->session->setFlash('success', 'Role created successfully.');

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionUpdate(string $name)
    {
        $roleService = new RoleService();

        $role = $roleService->find($name);

        if ($role === null) {
            throw new NotFoundHttpException('Role not found.');
        }

        $model = new RoleForm();
        $model->name = $role->name;
        $model->description = $role->description;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $roleService->update($name, $model);
            Yii::$app->session->setFlash('success', 'Role updated successfully.');
            return $this->redirect(['view', 'name' => $name]);
        }

        return $this->render('update', [
            'model' => $model,
            'role' => $role
        ]);
    }
}
