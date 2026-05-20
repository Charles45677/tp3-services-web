<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Film extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'title', 
        'release_year',
        'length',
        'description',
        'rating',
        'language_id',
        'special_features',
        'image'
    ];

    public function language() : BelongsTo
    {
        return $this->belongsTo('App\Models\Language');
    }


    public function critics() : HasMany
    {
        return $this->hasMany('App\Models\Critic');
    }
    
    public function actors() : BelongsToMany
    {
        return $this->belongsToMany('App\Models\Actor');
    }
}
