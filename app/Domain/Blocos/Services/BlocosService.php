<?php

namespace App\Domain\Blocos\Services;

use App\Domain\Blocos\Entities\Blocos;
use Illuminate\Database\Eloquent\Collection;

class BlocosService
{
    public function __construct(
        private Blocos $entity
    ) {
    }

    public function all(): Collection
    {
        return $this->entity->all();
    }

    public function find($id): ?Blocos
    {
        return $this->entity->find($id);
    }

    public function create(array $data): Blocos
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
