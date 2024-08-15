<?php

namespace App\Domain\Apartments\Services;

use App\Domain\Apartments\Entities\Apartments;
use Illuminate\Database\Eloquent\Collection;

class ApartmentsService
{
    public function __construct(
        private Apartments $entity
    ) {
    }

    public function all(): Collection
    {
        return $this->entity->all();
    }

    public function find($id): ?Apartments
    {
        return $this->entity->find($id);
    }

    public function create(array $data): Apartments
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

    public function findByUserBlockNumberFloor($user_id, $block_id, $number, $floor): ?Apartments
    {
        return $this->entity->where('user_id', $user_id)
            ->where('block_id', $block_id)
            ->where('number', $number)
            ->where('floor', $floor)
            ->first();
    }
}
