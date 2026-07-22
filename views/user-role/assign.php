<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User[] $users */
/** @var app\models\Role[] $roles */

$this->title = 'Assign Role To User';
?>

    <h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin([
    'method' => 'post',
]); ?>

    <div class="form-group">
        <label>User</label>

        <?= Html::dropDownList(
            'user_id',
            null,
            \yii\helpers\ArrayHelper::map(
                $users,
                'id',
                'username'
            ),
            [
                'class' => 'form-control',
                'prompt' => 'Select User'
            ]
        ) ?>
    </div>


    <div class="form-group">
        <label>Role</label>

        <?= Html::dropDownList(
            'role_id',
            null,
            \yii\helpers\ArrayHelper::map(
                $roles,
                'id',
                'name'
            ),
            [
                'class' => 'form-control',
                'prompt' => 'Select Role'
            ]
        ) ?>
    </div>


    <div class="form-group mt-3">
        <?= Html::submitButton(
            'Assign',
            [
                'class' => 'btn btn-primary'
            ]
        ) ?>
    </div>

<?php ActiveForm::end(); ?>
