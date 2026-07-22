<?php

namespace app\controllers;

use app\controllers\BaseController;
use app\services\UserService;

class UserController extends BaseController
{
    public function __construct($id, $module, private readonly UserService $userService, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $dataProvider = $this->userService->getDataProvider();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView(int $id)
    {
        $user = $this->userService->getUserById($id);
        return $this->render('view', [
            'user' => $user,
        ]);
    }

    public function actionUpdate(int $id)
    {
        $model = $this->userService->getUserById($id);
        if ($this->request->isPost) {
            $model->load($this->request->post());
            if ($this->userService->updateUser($model)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
