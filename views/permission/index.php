<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var array $permissions */

$this->title = 'Permissions';
?>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

            <h4 class="mb-0">
                <?= Html::encode($this->title) ?>
            </h4>

            <?= Html::a(
                'Sync Role Permissions',
                ['sync-permission-to-role'],
                ['class' => 'btn btn-success btn-sm']
            ) ?>

        </div>

        <div class="card-body table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-dark">

                <tr>

                    <th>Permission</th>

                    <th class="text-center">Roles</th>

                    <th class="text-center">Users</th>

                    <th class="text-center">Action</th>

                </tr>

                </thead>

                <tbody>

                <?php foreach ($permissions as $permission): ?>

                    <tr>

                        <td>
                            <strong>
                                <?= Html::encode($permission['name']) ?>
                            </strong>
                        </td>

                        <td class="text-center">

                            <span class="badge bg-primary fs-6">
                                <?= $permission['roleCount'] ?>
                            </span>

                        </td>

                        <td class="text-center">

                            <span class="badge bg-success fs-6">
                                <?= $permission['userCount'] ?>
                            </span>

                        </td>

                        <td class="text-center">

                            <?= Html::a(
                                'View',
                                [
                                    'view',
                                    'permission' => $permission['name']
                                ],
                                [
                                    'class' => 'btn btn-outline-info btn-sm'
                                ]
                            ) ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
