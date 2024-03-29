<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Song extends Model
{

    protected $fillable = [
        'file',
        'title',
        'duration',
        'size',
        'description',
        'album_id',
    ];

    public function album(){
        return $this->belongsTo(Album::class, 'album_id');
    }
}
