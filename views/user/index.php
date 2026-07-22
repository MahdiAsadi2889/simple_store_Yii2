<?php

use app\models\User;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
?>

<div class="user-index">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3 class="mb-0">
            <?= Html::encode($this->title) ?>
        </h3>

    </div>

    <div class="card shadow">

        <div class="card-body">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,

                'tableOptions' => [
                    'class' => 'table table-hover table-striped align-middle',
                ],

                'columns' => [

                    [
                        'attribute' => 'id',
                        'contentOptions' => [
                            'style' => 'width:70px'
                        ]
                    ],

                    'username',
                    'email:email',

                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => static function ($model) {

                            if ($model->status == User::STATUS_ACTIVE) {
                                return '<span class="badge bg-success">Active</span>';
                            }

                            return '<span class="badge bg-danger">Inactive</span>';
                        }
                    ],

                    [
                        'attribute' => 'created_at',
                        'format' => ['datetime', 'php:Y-m-d H:i'],
                    ],

                    [
                        'class' => ActionColumn::class,
                        'template' => '{view} {update}',
                        'contentOptions' => [
                            'style' => 'width:120px'
                        ]
                    ],

                ],

            ]); ?>

        </div>

    </div>

</div>
