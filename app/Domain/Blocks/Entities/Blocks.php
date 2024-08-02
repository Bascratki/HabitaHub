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
        'num_block',
        'num_apartments',
    ];
    
    public function condominium()
    {
        return $this->belongsTo('App\Domain\Condominiums\Entities\Condominiums');
    }

}
