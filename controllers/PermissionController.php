<?php

namespace app\controllers;

use app\controllers\BaseController;
use app\models\Role;
use app\models\User;
use app\services\PermissionService;
use Yii;
use yii\web\NotFoundHttpException;

class PermissionController extends BaseController
{
    public function __construct($id, $module, private readonly PermissionService $permissionService, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionAssignPermissionToRole()
    {
//        $this->checkAccess('permission/assign');
        if ($this->request->isPost) {
            $roleId = Yii::$app->request->post('role_id');
            $permissions = Yii::$app->request->post('permissions', []);

            $role = Role::findOne($roleId);

            if ($role === null) {
                throw new NotFoundHttpException('Role Not Found');
            }

            $result = $this->permissionService->assignPermissionsToRole($role, $permissions);

            Yii::$app->session->setFlash(
                $result ? 'success' : 'error',
                $result
                    ? 'Permissions updated successfully'
                    : 'Failed to update permissions'
            );

            return $this->redirect(['role/index']);
        }
        return $this->render('assign-role', [
            'roles' => Role::find()->all(),
        ]);
    }

    public function actionRemovePermissionFromRole()
    {
//        $this->checkAccess('permission/remove');
        $roleId = Yii::$app->request->post('role_id');
        $permission = Yii::$app->request->post('permission');

        $role = Role::findOne($roleId);

        if ($role === null) {
            throw new NotFoundHttpException('Role Not Found');
        }
        $result = $this->permissionService->removePermissionFromRole($role, $permission);
        Yii::$app->session->setFlash($result ? 'success' : 'error', $result ? 'Permission removed successfully' : 'Failed to remove permission from role');
        return $this->redirect(['role/index']);
    }

    public function actionAssignPermissionToUser()
    {
        if($this->request->isPost) {
//        $this->checkAccess('permission/assign');
            $userId = Yii::$app->request->post('user_id');
            $permissions = Yii::$app->request->post('permissions', []);

            $user = User::findOne($userId);
            if ($user === null) {
                throw new NotFoundHttpException('User Not Found');
            }

            $result = $this->permissionService->assignPermissionsToUser($user, $permissions);
            Yii::$app->session->setFlash($result ? 'success' : 'error', $result ? 'Permission assigned successfully' : 'Failed to assign permission to user');
            return $this->redirect(['user/index']);
        }
        return $this->render('assign-user', [
            'users' => User::find()->all(),
        ]);
    }

    public function actionRemovePermissionFromUser()
    {
//        $this->checkAccess('permission/assign');
        $userId = Yii::$app->request->post('user_id');
        $permission = Yii::$app->request->post('permission');

        $user = User::findOne($userId);
        if ($user === null) {
            throw new NotFoundHttpException('User Not Found');
        }
        $result = $this->permissionService->removePermissionFromUser($user, $permission);
        Yii::$app->session->setFlash($result ? 'success' : 'error', $result ? 'Permission removed successfully' : 'Failed to remove permission from user');
        return $this->redirect(['user/index']);
    }
}
