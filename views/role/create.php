<?php

use yii\helpers\Html;
/** @var app\models\RoleForm $model */

$this->title = 'Create Role';

?>

<h1><?= Html::encode($this->title) ?></h1>
<?= $this->render('_form', [
    'model' => $model
]) ?>