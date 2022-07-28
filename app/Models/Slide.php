<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slide extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'number',
        'file'
    ];

    protected $dates = [
        'deleted_at'
    ];
}
