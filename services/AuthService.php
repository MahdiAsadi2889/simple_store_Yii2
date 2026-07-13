<?php

namespace app\services;

use app\forms\LoginForm;
use app\forms\RegisterForm;

class AuthService
{
    public  function __construct(private readonly JwtService $jwtService)
    {

    }

    public function register(RegisterForm $form)
    {

    }

    public function login(LoginForm $form)
    {

    }
}
