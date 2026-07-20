<?php

namespace app\controllers;

use app\controllers\BaseController;
use app\models\Role;
use app\models\User;
use app\services\RoleService;
use Yii;
use yii\web\NotFoundHttpException;

class UserRoleController extends BaseController
{

    public function __construct(
        $id,
        $module,
        private readonly RoleService $roleService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
    }

    public function actionAssignRole()
    {
        $this->checkAccess('role/assign');

        $userId = Yii::$app->request->post('user_id');
        $roleId = Yii::$app->request->post('role_id');
        $user = User::findOne($userId);
        if ($user === null) {
            throw new NotFoundHttpException('User not found');
        }
        $role = Role::findOne($roleId);
        if ($role === null) {
            throw new NotFoundHttpException('Role not found');
        }

        $result = $this->roleService->assignRoleToUser($user, $role);

        Yii::$app->session->setFlash($result ? 'success' : 'error', $result ? 'Role assigned successfully' : 'Failed to assign role');

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRemoveRole()
    {
        $this->checkAccess('role/remove');
        $userId = Yii::$app->request->post('user_id');
        $roleId = Yii::$app->request->post('role_id');

        $user = User::findOne($userId);
        if ($user === null) {
            throw new NotFoundHttpException('User not found');
        }
        $role = Role::findOne($roleId);
        if ($role === null) {
            throw new NotFoundHttpException('Role not found');
        }

        $result = $this->roleService->removeRoleFromUser($user, $role);

        Yii::$app->session->setFlash($result ? 'success' : 'error', $result ? 'Role removed successfully' : 'Failed to remove assign role');

        return $this->redirect(['index']);
    }
}
