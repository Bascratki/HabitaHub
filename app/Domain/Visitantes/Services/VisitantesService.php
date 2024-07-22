<?php

namespace App\Domain\Visitantes\Services;

use App\Domain\Visitantes\Entities\Visitantes;
use Illuminate\Database\Eloquent\Collection;

class VisitantesService
{
    public function __construct(
        private Visitantes $entity
    ) {
    }

    public function all(): Collection
    {
        return $this->entity->all();
    }

    public function find($id): ?Visitantes
    {
        return $this->entity->find($id);
    }

    public function create(array $data): Visitantes
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
