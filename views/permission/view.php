<?php

use yii\helpers\Html;

/** @var string $permission */
/** @var app\models\Role[] $roles */
/** @var app\models\User[] $users */

$this->title = $permission;
?>

    <div class="container-fluid py-4">

        <div class="card border-0 shadow-lg mb-4 role-hero">

            <div class="card-body d-flex justify-content-between align-items-center">

                <div>

                <span class="role-icon">
                    🔑
                </span>

                    <h2 class="mt-3 mb-2 fw-bold">

                        <?= Html::encode($permission) ?>

                    </h2>

                    <p class="text-secondary mb-0">

                        View all roles and users assigned to this permission.

                    </p>

                </div>

                <?= Html::a(
                    '← Back',
                    ['index'],
                    [
                        'class' => 'btn btn-outline-secondary'
                    ]
                ) ?>

            </div>

        </div>

        <div class="row g-4 mb-4">

            <div class="col-lg-6">

                <div class="card border-0 shadow stat-card">

                    <div class="card-body text-center">

                        <div class="display-5 mb-2">
                            🛡
                        </div>

                        <div class="stat-number">

                            <?= count($roles) ?>

                        </div>

                        <div class="text-secondary">

                            Roles

                        </div>

                    </div>

                </div>

            </div>

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

                            Direct Users

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

                            🛡 Roles

                        </h4>

                    </div>

                    <div class="card-body custom-scroll">

                        <?php if ($roles): ?>

                            <?php foreach ($roles as $role): ?>

                                <div class="modern-list-item">

                                    <div>

                                        <div class="fw-semibold">

                                            <?= Html::encode($role->name) ?>

                                        </div>

                                        <small class="text-secondary">

                                            Role

                                        </small>

                                    </div>

                                    <span class="arrow">

                                    →

                                </span>

                                </div>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <div class="empty-box">

                                No Role Assigned

                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

            <div class="col-lg-6">

                <div class="card border-0 shadow-lg h-100">

                    <div class="card-header bg-transparent border-0 pt-4">

                        <h4 class="fw-bold">

                            👥 Direct Users

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

                                            Direct Permission

                                        </small>

                                    </div>

                                    <span class="arrow">

                                    →

                                </span>

                                </div>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <div class="empty-box">

                                No Direct User

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
    justify-content:center;
    align-items:center;
    border-radius:18px;
    background:rgba(var(--bs-primary-rgb),.12);
    font-size:34px;
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

.custom-scroll{
    max-height:420px;
    overflow-y:auto;
    padding-right:6px;
}

.custom-scroll::-webkit-scrollbar{
    width:8px;
}

.custom-scroll::-webkit-scrollbar-thumb{
    border-radius:20px;
    background:rgba(var(--bs-secondary-rgb),.35);
}

.custom-scroll::-webkit-scrollbar-thumb:hover{
    background:rgba(var(--bs-primary-rgb),.7);
}

.modern-list-item{
    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:16px 18px;

    margin-bottom:12px;

    border-radius:14px;

    border:1px solid var(--bs-border-color);

    transition:.2s;
}

.modern-list-item:hover{

    transform:translateX(6px);

    border-color:var(--bs-primary);

    background:rgba(var(--bs-primary-rgb),.06);

    box-shadow:0 6px 18px rgba(0,0,0,.08);

}

.arrow{

    font-size:20px;

    color:var(--bs-secondary);

}

.empty-box{

    border:2px dashed var(--bs-border-color);

    border-radius:14px;

    padding:40px;

    text-align:center;

    color:var(--bs-secondary);

}

CSS);
?>
