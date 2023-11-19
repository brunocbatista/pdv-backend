<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class GetUserToLogin
{
    /**
     * @param string $email
     * @param string $password
     * @return Model
     */
    public function handle(string $email, string $password): Model
    {
        $data = User::query()
            ->with('type:id,description,abilities')
            ->select('id', 'name', 'email', 'password', 'type_id')
            ->where('email', $email)
            ->first();

        if (!$data || !Hash::check($password, $data->password)) {
            abort(Response::HTTP_FORBIDDEN, 'E-mail ou senha incorretos.');
        }

        return $data;
    }
}
