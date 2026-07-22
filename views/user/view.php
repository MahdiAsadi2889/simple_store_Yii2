<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $user */

$this->title = 'View User';
?>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header">

            <h4><?= Html::encode($this->title) ?></h4>

        </div>

        <div class="card-body">

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
                    <th>Email</th>
                    <td><?= Html::encode($user->email) ?></td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td><?= $user->status ?></td>
                </tr>

                <tr>
                    <th>Created At</th>
                    <td><?= date('Y-m-d H:i', $user->created_at) ?></td>
                </tr>

                <tr>
                    <th>Updated At</th>
                    <td><?= date('Y-m-d H:i', $user->updated_at) ?></td>
                </tr>

            </table>

        </div>

    </div>

</div>
