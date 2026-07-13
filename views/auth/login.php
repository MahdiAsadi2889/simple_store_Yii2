<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var $model app\forms\LoginForm */

$this->title = 'Login';


$this->registerCss(<<<CSS

.auth-page {
    min-height: 100vh;
    background: #f5f7fb;

    display: flex;
    justify-content: center;
    align-items: center;

    padding: 30px;
}


.auth-card {

    width: 100%;
    max-width: 420px;

    background: #ffffff;

    border-radius: 18px;

    padding: 35px;

    box-shadow:
        0 15px 40px rgba(0,0,0,.08);
}


.auth-title {

    text-align: center;

    font-size: 28px;

    font-weight: 700;

    color: #111827;

    margin-bottom: 8px;
}



.auth-subtitle {

    text-align: center;

    color: #6b7280;

    margin-bottom: 30px;

}



.form-label {

    color: #111827;

    font-weight: 600;

    margin-bottom: 8px;

    display:block;

}



.form-control {

    height: 48px;

    background: #ffffff;

    border: 1px solid #d1d5db;

    border-radius: 12px;

    padding: 0 15px;

    font-size: 15px;

}



.form-control:focus {

    border-color: #2563eb;

    box-shadow:
        0 0 0 3px rgba(37,99,235,.12);

}



.form-group {

    margin-bottom: 20px;

}



.btn-login {

    width:100%;

    height:48px;

    border-radius:12px;

    background:#2563eb;

    border:none;

    color:white;

    font-weight:600;

    font-size:15px;

    transition:.2s;

}



.btn-login:hover {

    background:#1d4ed8;

}



.auth-footer {

    text-align:center;

    margin-top:25px;

    color:#6b7280;

}


.auth-footer a {

    color:#2563eb;

    font-weight:600;

}


CSS);

?>


<div class="auth-page">


    <div class="auth-card">


        <h1 class="auth-title">
            Welcome Back
        </h1>


        <p class="auth-subtitle">
            Login to your account
        </p>



        <?php $form = ActiveForm::begin(); ?>



        <?= $form->field($model,'login')
            ->textInput([
                'placeholder'=>'Username or Email'
            ])
            ->label('Username or Email',[
                'class'=>'form-label'
            ])
        ?>



        <?= $form->field($model,'password')
            ->passwordInput([
                'placeholder'=>'Password'
            ])
            ->label('Password',[
                'class'=>'form-label'
            ])
        ?>



        <?= Html::submitButton(
            'Login',
            [
                'class'=>'btn btn-login'
            ]
        ) ?>



        <?php ActiveForm::end(); ?>



        <div class="auth-footer">

            Don't have an account?

            <?= Html::a(
                'Create Account',
                ['register']
            ) ?>

        </div>


    </div>


</div>
