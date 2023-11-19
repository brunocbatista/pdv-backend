<?php

namespace App\Http\Controllers;

use App\Actions\Authentication\DeleteCurrentAccessToken;

class LogoutController extends Controller
{
    public function store(DeleteCurrentAccessToken $deleteCurrentAccessToken)
    {
        $deleteCurrentAccessToken->handle();

        return $this->sendJsonOK();
    }
}
