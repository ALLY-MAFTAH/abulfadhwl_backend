<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'file',
        'cover',
        'title',
        'pub_year',
    ];

    protected $dates=[
        'deleted_at'
    ];
}
