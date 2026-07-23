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

    public function actionSyncPermissionsToRole()
    {
        $selectedRoleId = Yii::$app->request->get('role_id');
        $currentPermissions = [];

        if ($this->request->isPost) {
            $selectedRoleId = $this->request->post('role_id');
            $permissions = Yii::$app->request->post('permissions', []);
            $role = Role::findOne($selectedRoleId);

            if ($role === null) {
                throw new NotFoundHttpException('Role not found');
            }

            $result = $this->permissionService->syncPermissionsToRole($role, $permissions);

            Yii::$app->session->setFlash($result ? 'success' : 'error', $result ? 'Permissions synced successfully' : 'Failed to synced permissions');

            return $this->redirect([
                'sync-permissions-to-role',
                'role_id' => $selectedRoleId,
            ]);
        }
        if($selectedRoleId){
            $currentPermissions = $this->permissionService->getRolePermissions((int)$selectedRoleId);
        }

        return $this->render('sync-role',[
            'roles' => Role::find()->all(),
            'selectedRoleId' => $selectedRoleId,
            'currentPermissions' => $currentPermissions
        ]);
    }

    public function actionSyncPermissionsToUser()
    {
        $selectedUserId = Yii::$app->request->get('user_id');
        $currentPermissions = [];

        if ($this->request->isPost) {
            $selectedUserId = Yii::$app->request->post('user_id');
            $permissions = Yii::$app->request->post('permissions', []);
            $user = User::findOne($selectedUserId);

            if ($user === null) {
                throw new NotFoundHttpException('User Not Found');
            }

            $result = $this->permissionService->syncPermissionsToUser($user, $permissions);

            Yii::$app->session->setFlash(
                $result ? 'success' : 'error',
                $result ? 'Permissions synced successfully' : 'Failed to synced permissions'
            );
            return $this->redirect([
                'sync-permissions-to-user',
                'user_id' => $selectedUserId,
            ]);
        }
        if ($selectedUserId) {
            $currentPermissions = $this->permissionService->getUserPermissions((int) $selectedUserId);
        }

        return $this->render('sync-user', [
            'users' => User::find()->all(),
            'selectedUserId' => $selectedUserId,
            'currentPermissions' => $currentPermissions,
        ]);
    }

}
