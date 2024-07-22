<?php

namespace App\Domain\Condominios\Services;

use App\Domain\Condominios\Entities\Condominios;
use Illuminate\Database\Eloquent\Collection;

class CondominiosService
{
    public function __construct(
        private Condominios $entity
    ) {
    }

    public function all(): Collection
    {
        return $this->entity->all();
    }

    public function find($id): ?Condominios
    {
        return $this->entity->find($id);
    }

    public function create(array $data): Condominios
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
