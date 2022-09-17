<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable=[
    'full_name',
    'phone',
    'message'
    ];

    protected $dates=[
        'deleted_at'
    ];
}
