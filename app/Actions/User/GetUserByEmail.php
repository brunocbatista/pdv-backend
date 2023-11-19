<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class GetUserByEmail
{
    /**
     * @param string $email
     * @return Model
     */
    public function handle(string $email): Model
    {
        $data = User::query()
            ->select('id', 'name', 'email')
            ->where('email', $email)
            ->first();

        if (!$data) {
            abort(Response::HTTP_NOT_FOUND, 'Usuário não encontrado. Por favor, tente novamente!');
        }

        return $data;
    }
}
