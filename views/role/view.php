<?php

use yii\helpers\Html;

/** @var yii\rbac\Role $role */

$this->title = 'Role Details - ' . $role->name;
?>

<div class="role-view">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>
            <?= Html::encode($role->name) ?>
        </h1>

        <div>
            <?= Html::a('Back', ['index'], [
                'class' => 'btn btn-secondary'
            ]) ?>

            <?= Html::a('Update', ['update', 'name' => $role->name], [
                'class' => 'btn btn-primary'
            ]) ?>
        </div>
    </div>


    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">
            Role Information
        </div>

        <div class="card-body">

            <div class="row mb-3">

                <div class="col-md-3 fw-bold">
                    Name
                </div>

                <div class="col-md-9">
                    <?= Html::encode($role->name) ?>
                </div>

            </div>


            <div class="row mb-3">

                <div class="col-md-3 fw-bold">
                    Description
                </div>

                <div class="col-md-9">
                    <?= $role->description
                        ? Html::encode($role->description)
                        : '<span class="text-muted">No description</span>' ?>
                </div>

            </div>


        </div>

    </div>


    <div class="card shadow-sm mt-4">

        <div class="card-header">
            Permissions
        </div>

        <div class="card-body">

            <span class="badge bg-info">
                Coming soon
            </span>

            <p class="text-muted mt-2">
                Role permissions will be managed here.
            </p>

        </div>

    </div>


</div>