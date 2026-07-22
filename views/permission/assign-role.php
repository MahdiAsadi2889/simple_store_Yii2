<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\PermissionRegistry;

/** @var yii\web\View $this */
/** @var app\models\Role[] $roles */

$this->title = 'Assign Permission To Role';

$permissions = PermissionRegistry::all();
?>

    <div class="container mt-4">

        <div class="card shadow">

            <div class="card-header bg-dark text-white">
                <h4 class="mb-0">
                    <?= Html::encode($this->title) ?>
                </h4>
            </div>

            <div class="card-body">

                <?php $form = ActiveForm::begin([
                    'action' => ['assign-permission-to-role'],
                    'method' => 'post',
                ]); ?>

                <div class="mb-4">

                    <label class="form-label fw-bold">
                        Select Role
                    </label>

                    <?= Html::dropDownList(
                        'role_id',
                        null,
                        ArrayHelper::map($roles, 'id', 'name'),
                        [
                            'class' => 'form-select',
                            'prompt' => 'Choose Role'
                        ]
                    ) ?>

                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="mb-0">
                        Permissions
                    </h5>

                    <div>

                        <button
                            type="button"
                            id="check-all"
                            class="btn btn-outline-success btn-sm me-2"
                        >
                            Select All
                        </button>

                        <button
                            type="button"
                            id="uncheck-all"
                            class="btn btn-outline-danger btn-sm"
                        >
                            Unselect All
                        </button>

                    </div>

                </div>

                <div class="row">

                    <?php foreach ($permissions as $permission): ?>

                        <div class="col-md-4 mb-3">

                            <div class="permission-item">

                                <div class="form-check m-0">

                                    <input
                                        class="form-check-input permission-checkbox"
                                        type="checkbox"
                                        name="permissions[]"
                                        value="<?= Html::encode($permission) ?>"
                                        id="<?= md5($permission) ?>"
                                    >

                                    <label
                                        class="form-check-label ms-2"
                                        for="<?= md5($permission) ?>"
                                    >
                                        <?= Html::encode($permission) ?>
                                    </label>

                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

                <hr>

                <div class="text-end">

                    <?= Html::submitButton(
                        'Save Permissions',
                        [
                            'class' => 'btn btn-success px-4'
                        ]
                    ) ?>

                </div>

                <?php ActiveForm::end(); ?>

            </div>

        </div>

    </div>

<?php

$this->registerJs(<<<JS

$('#check-all').click(function () {
    $('.permission-checkbox').prop('checked', true);
});

$('#uncheck-all').click(function () {
    $('.permission-checkbox').prop('checked', false);
});

JS);

$this->registerCss(<<<CSS

.permission-item{
    border:1px solid var(--bs-border-color);
    border-radius:12px;
    padding:14px 16px;
    background:var(--bs-body-bg);
    color:var(--bs-body-color);
    transition:.25s ease;
    cursor:pointer;
}

.permission-item:hover{
    border-color:var(--bs-success);
    background:rgba(var(--bs-success-rgb),.08);
    transform:translateY(-2px);
    box-shadow:0 4px 12px rgba(0,0,0,.08);
}

.permission-item .form-check{
    display:flex;
    align-items:center;
    margin:0;
}

.permission-item .form-check-input{
    width:20px;
    height:20px;
    cursor:pointer;
    margin:0;
}

.permission-item .form-check-label{
    margin-left:12px;
    font-size:15px;
    font-weight:500;
    color:inherit;
    cursor:pointer;
    user-select:none;
}

CSS);

?>
