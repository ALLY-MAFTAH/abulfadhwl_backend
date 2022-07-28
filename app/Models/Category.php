<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description'
    ];

    protected $dates = [
        'deletedAt'
    ];

    public function albums()
    {
        return $this->hasMany(Album::class);
    }
}
