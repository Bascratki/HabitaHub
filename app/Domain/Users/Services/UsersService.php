<?php

namespace App\Domain\Usuarios\Services;

use App\Domain\Usuarios\Entities\Usuario;
use Illuminate\Database\Eloquent\Collection;

class UsuariosService
{
    public function __construct(
        private Usuario $entity
    ) {
    }

    public function all(): Collection
    {
        return $this->entity->all();
    }

    public function find($id): ?Usuario
    {
        return $this->entity->find($id);
    }

    public function create(array $data): Usuario
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
