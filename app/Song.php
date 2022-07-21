<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Song extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'file',
        'title',
        'duration',
        'description',
    ];

    protected $dates = [
        'deletedAt'
    ];

    public function album(){
        return $this->belongsTo(Album::class);
    }
}
