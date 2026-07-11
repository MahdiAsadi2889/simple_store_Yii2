<?php

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\data\ArrayDataProvider $dataProvider */

$this->title = 'Roles';
?>

<div class="role-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Role', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],

            'name',

            'description',

            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, $model) {
                    return [$action, 'name' => $model->name];
                },
            ],
        ],
    ]); ?>

</div>