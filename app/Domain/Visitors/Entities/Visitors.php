<?php

namespace App\Domain\Visitors\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitors extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'apartment_id',
        'condominium_id',
        'name',
        'type',
        'document_type',
        'document_number',
        'status'
    ];

}
