<?php

namespace App\Domain\Empresas\Services;

use App\Domain\Empresas\Entities\Empresas;
use Illuminate\Database\Eloquent\Collection;

class EmpresasService
{
    public function __construct(
        private Empresas $entity
    ) {
    }

    public function all(): Collection
    {
        return $this->entity->all();
    }

    public function find($id): ?Empresas
    {
        return $this->entity->find($id);
    }

    public function create(array $data): Empresas
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
