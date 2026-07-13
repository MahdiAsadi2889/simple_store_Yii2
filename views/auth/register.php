<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var $model app\forms\RegisterForm */

$this->title = 'Register';


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



/* Label */

.form-label {

    color: #111827;

    font-weight: 600;

    margin-bottom: 8px;

    display:block;

}



/* Input */

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



/* فاصله بین فیلدها */

.form-group {

    margin-bottom: 20px;

}



/* Button */

.btn-register {

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



.btn-register:hover {

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
            Create Account
        </h1>


        <p class="auth-subtitle">
            Register to continue
        </p>



        <?php $form = ActiveForm::begin(); ?>



        <?= $form->field($model,'username')
            ->textInput([
                'placeholder'=>'Username'
            ])
            ->label('Username',[
                'class'=>'form-label'
            ])
        ?>


        <?= $form->field($model,'email')
            ->textInput([
                'placeholder'=>'Email address'
            ])
            ->label('Email',[
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


        <?= $form->field($model,'confirmPassword')
            ->passwordInput([
                'placeholder'=>'Confirm password'
            ])
            ->label('Confirm Password',[
                'class'=>'form-label'
            ])
        ?>



        <?= Html::submitButton(
            'Create Account',
            [
                'class'=>'btn btn-register'
            ]
        ) ?>


        <?php ActiveForm::end(); ?>



        <div class="auth-footer">

            Already have an account?

            <?= Html::a(
                'Login',
                ['login']
            ) ?>

        </div>


    </div>


</div>
