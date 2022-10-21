<?php

declare(strict_types=1);

namespace App\Services;

class UserService
{

    public array $loginFields = [
        'email' => ['required', 'email'],
        'password' => ['required', 'min:6']
    ];

}
