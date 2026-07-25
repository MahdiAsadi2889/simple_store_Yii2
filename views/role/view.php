<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Role $role */
/** @var app\models\User[] $users */
/** @var string[] $permissions */

$this->title = $role->name;
?>

    <div class="container-fluid py-4">

        <div class="card border-0 shadow-lg mb-4 role-hero">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>

                <span class="role-icon">
                    🛡
                </span>

                    <h2 class="mt-3 mb-2 fw-bold">

                        <?= Html::encode($role->name) ?>

                    </h2>

                    <p class="text-secondary mb-0">

                        Manage users and permissions assigned to this role.

                    </p>

                </div>

                <div>

                    <?= Html::a(
                        '← Back',
                        ['index'],
                        [
                            'class' => 'btn btn-outline-secondary'
                        ]
                    ) ?>

                </div>

            </div>

        </div>


        <div class="row g-4 mb-4">

            <div class="col-lg-6">

                <div class="card border-0 shadow stat-card">

                    <div class="card-body text-center">

                        <div class="display-5 mb-2">
                            👥
                        </div>

                        <div class="stat-number">

                            <?= count($users) ?>

                        </div>

                        <div class="text-secondary">

                            Assigned Users

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-6">

                <div class="card border-0 shadow stat-card">

                    <div class="card-body text-center">

                        <div class="display-5 mb-2">
                            🔑
                        </div>

                        <div class="stat-number">

                            <?= count($permissions) ?>

                        </div>

                        <div class="text-secondary">

                            Permissions

                        </div>

                    </div>

                </div>

            </div>


        </div>


        <div class="row g-4">

            <div class="col-lg-6">

                <div class="card border-0 shadow-lg h-100">

                    <div class="card-header bg-transparent border-0 pt-4">

                        <h4 class="fw-bold">

                            👥 Users

                        </h4>

                    </div>

                    <div class="card-body custom-scroll">

                        <?php if ($users): ?>

                            <?php foreach ($users as $user): ?>

                                <div class="modern-list-item">

                                    <div>

                                        <div class="fw-semibold">

                                            <?= Html::encode($user->username) ?>

                                        </div>

                                        <small class="text-secondary">

                                            User

                                        </small>

                                    </div>

                                    <span class="arrow">

                                    →

                                </span>

                                </div>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <div class="empty-box">

                                No User Assigned

                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

            <div class="col-lg-6">

                <div class="card border-0 shadow-lg h-100">

                    <div class="card-header bg-transparent border-0 pt-4">

                        <h4 class="fw-bold">

                            🔑 Permissions

                        </h4>

                    </div>

                    <div class="card-body custom-scroll">

                        <?php if ($permissions): ?>

                            <?php foreach ($permissions as $permission): ?>

                                <div class="modern-list-item permission-item">

                                    <div>

                                        <?= Html::encode($permission) ?>

                                    </div>

                                    <span class="permission-check">

                                    ✓

                                </span>

                                </div>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <div class="empty-box">

                                No Permission Assigned

                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

<?php

$this->registerCss(<<<CSS

.role-hero{
    border-radius:20px;
}

.role-icon{
    width:70px;
    height:70px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    font-size:34px;
    border-radius:18px;
    background:rgba(var(--bs-primary-rgb),.12);
}

.stat-card{
    border-radius:18px;
    transition:.25s;
}

.stat-card:hover{
    transform:translateY(-5px);
}

.stat-number{
    font-size:34px;
    font-weight:700;
}

.modern-list-item{

    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:16px 18px;

    border-radius:14px;

    margin-bottom:12px;

    background:var(--bs-body-bg);

    border:1px solid var(--bs-border-color);

    transition:.2s;
}

.modern-list-item:hover{

transform:translateX(6px) scale(1.01);

box-shadow:0 6px 18px rgba(0,0,0,.08);

    border-color:var(--bs-primary);

    background:rgba(var(--bs-primary-rgb),.06);
}

.permission-item:hover{

    border-color:var(--bs-success);

    background:rgba(var(--bs-success-rgb),.08);

}

.arrow{

    font-size:20px;

    color:var(--bs-secondary);

}

.permission-check{

    color:#22c55e;

    font-size:20px;

    font-weight:bold;

}

.empty-box{

    border:2px dashed var(--bs-border-color);

    border-radius:14px;

    padding:40px;

    text-align:center;

    color:var(--bs-secondary);

}

.custom-scroll{

    max-height:420px;

    overflow-y:auto;

    padding-right:8px;

}

/* Chrome */

.custom-scroll::-webkit-scrollbar{

    width:8px;

}

.custom-scroll::-webkit-scrollbar-track{

    background:transparent;

}

.custom-scroll::-webkit-scrollbar-thumb{

    border-radius:20px;

    background:rgba(var(--bs-secondary-rgb),.35);

    transition:.2s;

}

.custom-scroll::-webkit-scrollbar-thumb:hover{

    background:rgba(var(--bs-primary-rgb),.7);

}

/* Firefox */

.custom-scroll{

    scrollbar-width:thin;

    scrollbar-color:rgba(100,100,100,.5) transparent;

}

CSS);
?>
