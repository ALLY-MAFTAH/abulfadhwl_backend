<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'name',
        'description',
        'category_id'
    ];

    protected $dates=[
        'deletedAt'
    ];

    public function songs()
    {
        return $this->hasMany(Song::class)->orderBy('title');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
