<?php

namespace App\Domain\Blocks\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blocks extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'condominium_id',
        'blocks',
        'apartments',
        'status'   
    ];

}