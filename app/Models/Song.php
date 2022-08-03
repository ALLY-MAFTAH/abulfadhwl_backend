<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Song extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'file',
        'title',
        'duration',
        'size',
        'description',
    ];

    protected $dates = [
        'deletedAt'
    ];

    public function album(){
        return $this->belongsTo(Album::class);
    }
}
