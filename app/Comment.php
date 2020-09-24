<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable=[
    'full_name',
    'email',
    'message'
    ];

    protected $dates=[
        'deleted_at'
    ];
}
