<?php

namespace App\Domain\Condominiums\Services;

use App\Domain\Condominiums\Entities\Condominiums;
use Illuminate\Database\Eloquent\Collection;

class CondominiumsService
{
    public function __construct(
        private Condominiums $entity
    ) {
    }

    public function all(): Collection
    {
        return $this->entity->all();
    }

    public function find($id): ?Condominiums
    {
        return $this->entity->find($id);
    }

    public function create(array $data): Condominiums
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
