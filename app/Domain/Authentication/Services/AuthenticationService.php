<?php

namespace App\Domain\Authentication\Services;

use App\Domain\Usuarios\Entities\Usuario;

class AuthenticationService
{
    public function __construct(
        private Usuario $entity
    ) {
    }

    public function register(array $data): Usuario
    {
        return $this->entity->create($data);
    }

    public function getByEmail($email): ?Usuario
    {
        return $this->entity->where('email', $email)->first();
    }
}
