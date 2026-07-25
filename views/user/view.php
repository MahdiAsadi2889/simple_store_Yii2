<?php

use yii\helpers\Html;

/** @var app\models\User $user */
/** @var app\models\Role[] $roles */
/** @var string[] $directPermissions */
/** @var string[] $effectivePermissions */

$this->title = 'User Details';
?>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-dark text-white d-flex justify-content-between">

            <h4 class="mb-0">
                <?= Html::encode($user->username) ?>
            </h4>

            <?= Html::a(
                'Back',
                ['index'],
                ['class' => 'btn btn-light btn-sm']
            ) ?>

        </div>

        <div class="card-body">

            <div class="row mb-4">

                <div class="col-md-6">

                    <table class="table table-bordered">

                        <tr>
                            <th>ID</th>
                            <td><?= $user->id ?></td>
                        </tr>

                        <tr>
                            <th>Username</th>
                            <td><?= Html::encode($user->username) ?></td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td><?= $user->status ?></td>
                        </tr>

                        <tr>
                            <th>Created At</th>
                            <td><?= Yii::$app->formatter->asDatetime($user->created_at) ?></td>
                        </tr>

                    </table>

                </div>

            </div>

            <div class="row">

                <div class="col-md-4">

                    <div class="card border-primary mb-3">

                        <div class="card-header bg-primary text-white">
                            Roles
                        </div>

                        <div class="card-body">

                            <?php if ($roles): ?>

                                <?php foreach ($roles as $role): ?>

                                    <span class="badge bg-primary me-1 mb-2">

                                        <?= Html::encode($role->name) ?>

                                    </span>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <span class="text-muted">
                                    No Role
                                </span>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card border-warning mb-3">

                        <div class="card-header bg-warning">
                            Direct Permissions
                        </div>

                        <div class="card-body">

                            <?php if ($directPermissions): ?>

                                <?php foreach ($directPermissions as $permission): ?>

                                    <span class="badge bg-warning text-dark me-1 mb-2">

                                        <?= Html::encode($permission) ?>

                                    </span>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <span class="text-muted">
                                    No Direct Permission
                                </span>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card border-success">

                        <div class="card-header bg-success text-white">
                            Effective Permissions
                        </div>

                        <div class="card-body">

                            <?php foreach ($effectivePermissions as $permission): ?>

                                <span class="badge bg-success me-1 mb-2">

                                    <?= Html::encode($permission) ?>

                                </span>

                            <?php endforeach; ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
