<?php

namespace app\controllers;

use app\controllers\BaseController;
use app\models\User;
use app\services\UserService;
use yii\web\NotFoundHttpException;

class UserController extends BaseController
{
    public function __construct($id, $module, private readonly UserService $userService, $config = [])
    {
        parent::__construct($id, $module, $config);
    }


    public function permissions(): array
    {
        return [

            'index' => 'user/view',

            'view' => 'user/view',

            'update' => 'user/update',

        ];
    }

    public function actionIndex()
    {
        $dataProvider = $this->userService->getDataProvider();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $user = User::findOne($id);

        if ($user === null) {
            throw new NotFoundHttpException('User not found');
        }

        return $this->render('view', [
            'user' => $user,
            'roles' => $this->userService->getUserRoles($user),
            'directPermissions' => $this->userService->getUserDirectPermissions($user),
            'effectivePermissions' => $this->userService->getUserEffectivePermissions($user),
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
