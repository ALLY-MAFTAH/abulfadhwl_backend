<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'file',
        'cover',
        'title',
        'author',
        'edition',
        'pub_year',
        'description'
    ];

    protected $dates=[
        'deleted at'
    ];
}
