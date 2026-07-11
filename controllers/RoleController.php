<?php

namespace app\controllers;

use app\models\RoleForm;
use app\services\RoleServices;
use Yii;
use yii\data\ArrayDataProvider;

class RoleController extends BaseController
{
    public function actionIndex()
    {
        $roleService = new RoleServices();

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
    public function actionCreate()
    {
        $model = new RoleForm();
        $roleService = new RoleServices();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $roleService->create($model);
            Yii::$app->session->setFlash('success', 'Role created successfully.');

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }
}
