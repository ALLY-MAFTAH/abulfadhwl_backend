<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'qn',
    ];

    protected $dates=[
        'deleted_at'
    ];
}
