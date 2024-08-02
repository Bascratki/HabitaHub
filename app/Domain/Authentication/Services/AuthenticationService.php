<?php

namespace App\Domain\Authentication\Services;

use App\Domain\Users\Entities\User;

class AuthenticationService
{
    public function __construct(
        private User $entity
    ) {
    }

    public function register(array $data): User
    {
        return $this->entity->create($data);
    }

    public function getByEmail($email): ?User
    {
        return $this->entity->where('email', $email)->first();
    }

    public function getByCpf($cpf): ?User
    {
        return $this->entity->where('cpf', $cpf)->first();
    }
}
