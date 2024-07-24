<?php

namespace App\Domain\Blocks\Services;

use App\Domain\Blocks\Entities\Blocks;
use Illuminate\Database\Eloquent\Collection;

class BlocksService
{
    public function __construct(
        private Blocks $entity
    ) {
    }

    public function all(): Collection
    {
        return $this->entity->all();
    }

    public function find($id): ?Blocks
    {
        return $this->entity->find($id);
    }

    public function create(array $data): Blocks
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
