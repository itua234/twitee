<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use App\Http\Requests\{
    VerifyAccount, ChangePassword
};

interface IAuthInterface
{
    public function verifyUser(VerifyAccount $request);

    public function change_password(ChangePassword $request);
}