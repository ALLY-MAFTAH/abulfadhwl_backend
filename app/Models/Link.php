<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'type',
        'title',
        'url',
        'icon',
        'status',
    ];
    protected $dates=[
        'deleted_at'
    ];
}
