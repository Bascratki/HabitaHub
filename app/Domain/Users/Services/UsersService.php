<?php

namespace App\Domain\Users\Services;

use App\Domain\Users\Entities\User;
use Illuminate\Database\Eloquent\Collection;

class UsersService
{
    public function __construct(
        private User $entity
    ) {
    }

    public function all(): Collection
    {
        return $this->entity->all();
    }

    public function find($id): ?User
    {
        return $this->entity->find($id);
    }

    public function create(array $data): User
    {
        return $this->entity->create($data);
    }

    public function update($id, array $data): bool
    {
        return $this->entity->find($id)->update($data);
    }

    public function delete($id): bool
    {
        return $this->entity->find($id)->delete();
    }
}
