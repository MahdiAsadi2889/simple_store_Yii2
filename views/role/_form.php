<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/** @var app\models\RoleForm $model */

$form = ActiveForm::begin();
?>

<?= $form->field($model, 'name')->textInput() ?>
<?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>

<div class="form-group mt-3">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end() ?>