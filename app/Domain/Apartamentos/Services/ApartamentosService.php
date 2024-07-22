<?php

namespace App\Domain\Apartamentos\Services;

use App\Domain\Apartamentos\Entities\Apartamentos;
use Illuminate\Database\Eloquent\Collection;

class ApartamentosService
{
    public function __construct(
        private Apartamentos $entity
    ) {
    }

    public function all(): Collection
    {
        return $this->entity->all();
    }

    public function find($id): ?Apartamentos
    {
        return $this->entity->find($id);
    }

    public function create(array $data): Apartamentos
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
