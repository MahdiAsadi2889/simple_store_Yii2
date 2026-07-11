<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/** @var app\models\RoleForm $model */

$form = ActiveForm::begin();
?>

<?= $form->field($model, 'name')->textInput() ?>
<?= $form->field($model, 'desctiption')->textarea(['rows' => 4]) ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end() ?>