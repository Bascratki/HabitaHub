<?php

namespace App\Domain\Companies\Services;

use App\Domain\Companies\Entities\Companies;
use Illuminate\Database\Eloquent\Collection;

class CompaniesService
{
    public function __construct(
        private Companies $entity
    ) {
    }

    public function all(): Collection
    {
        return $this->entity->all();
    }

    public function find($id): ?Companies
    {
        return $this->entity->find($id);
    }

    public function create(array $data): Companies
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
