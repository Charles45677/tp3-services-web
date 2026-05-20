<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Actor extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'last_name', 
        'first_name',
        'birthdate'

    ];

    public function films() : BelongsToMany
    {
        return $this->belongsToMany('App\Models\Film');
    }
}
