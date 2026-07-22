<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = 'Update User';
?>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-header">

            <h4><?= Html::encode($this->title) ?></h4>

        </div>

        <div class="card-body">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'username') ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'status') ?>

            <div class="mt-3">

                <?= Html::submitButton(
                    'Save',
                    ['class' => 'btn btn-success']
                ) ?>

            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>

</div>
