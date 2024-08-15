<?php

namespace App\Domain\Visitors\Services;

use App\Domain\Visitors\Entities\Visitors;
use Illuminate\Database\Eloquent\Collection;

class VisitorsService
{
    public function __construct(
        private Visitors $entity
    ) {
    }

    public function all(): Collection
    {
        return $this->entity->all();
    }

    public function find($id): ?Visitors
    {
        return $this->entity->find($id);
    }

    public function create(array $data): Visitors
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

    /**
     * Verifies if a visitor with the given document type and document number exists.
     *
     * @param string $documentType The document type of the visitor.
     * @param string $documentNumber The document number of the visitor.
     * @return bool Returns true if a visitor with the given document type and document number exists, false otherwise.
     */
    public function verificaDocumento(string $documentType, string $documentNumber): bool
    {
        return $this->entity->where('document_type', $documentType)->where('document_number', $documentNumber)->exists();
    }
}
