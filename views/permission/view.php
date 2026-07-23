<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var string $permission */
/** @var app\models\Role[] $roles */
/** @var app\models\User[] $users */

$this->title = $permission;
?>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

            <h4 class="mb-0">

                <?= Html::encode($permission) ?>

            </h4>

            <?= Html::a(
                'Back',
                ['index'],
                ['class' => 'btn btn-light btn-sm']
            ) ?>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <div class="card border-primary mb-3">

                        <div class="card-header bg-primary text-white">

                            Roles

                        </div>

                        <div class="card-body">

                            <?php if (!empty($roles)): ?>

                                <?php foreach ($roles as $role): ?>

                                    <span class="badge bg-primary me-1 mb-2 fs-6">

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

                <div class="col-md-6">

                    <div class="card border-success">

                        <div class="card-header bg-success text-white">

                            Users

                        </div>

                        <div class="card-body">

                            <?php if (!empty($users)): ?>

                                <?php foreach ($users as $user): ?>

                                    <span class="badge bg-success me-1 mb-2 fs-6">

                                        <?= Html::encode($user->username) ?>

                                    </span>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <span class="text-muted">
                                    No User
                                </span>

                            <?php endif; ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
