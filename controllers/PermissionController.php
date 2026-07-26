<?php

namespace app\controllers;

use app\components\PermissionRegistry;
use app\controllers\BaseController;
use app\models\Role;
use app\models\User;
use app\services\PermissionService;
use app\services\UserService;
use Yii;
use yii\web\NotFoundHttpException;

class PermissionController extends BaseController
{
    public function __construct($id, $module, private readonly PermissionService $permissionService, private readonly UserService $userService, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function permissions(): array
    {
        return [

            'index' => 'permission/view',

            'view' => 'permission/view',

            'sync-permissions-to-role' => 'permission/assign',

            'sync-permissions-to-user' => 'permission/assign',

        ];
    }


    public function actionIndex()
    {
        $permissions = [];
        foreach (PermissionRegistry::all() as $permission) {
            $permissions[] = [
                'name' => $permission,
                'roleCount' => $this->permissionService->getRoleCountByPermissions($permission),
                'userCount' => $this->permissionService->getUserCountByPermissions($permission),
            ];
        }

        return $this->render('index', [
            'permissions' => $permissions,
        ]);
    }

    public function actionView(string $permission)
    {
        if (!PermissionRegistry::exists($permission)) {
            throw new NotFoundHttpException('Permission not found');
        }
        $detail = $this->permissionService->getPermissionDetails($permission);

        return $this->render('view', [
            'permission' => $permission,
            'roles' => $detail['roles'],
            'users' => $detail['users'],
        ]);
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
        if ($selectedRoleId) {
            $currentPermissions = $this->permissionService->getRolePermissions((int) $selectedRoleId);
        }

        return $this->render('sync-role', [
            'roles' => Role::find()->all(),
            'selectedRoleId' => $selectedRoleId,
            'currentPermissions' => $currentPermissions
        ]);
    }

    public function actionSyncPermissionsToUser()
    {
        $selectedUserId = Yii::$app->request->get('user_id');
        $directPermissions = [];
        $effectivePermissions = [];

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

            $user = $this->userService
                ->getUserById((int) $selectedUserId);

            $directPermissions = $this->userService
                ->getUserDirectPermissions($user);

            $effectivePermissions = $this->userService
                ->getUserEffectivePermissions($user);
        }

        return $this->render('sync-user', [
            'users' => User::find()->all(),
            'selectedUserId' => $selectedUserId,
            'directPermissions' => $directPermissions,
            'effectivePermissions' => $effectivePermissions,
        ]);
    }

}
