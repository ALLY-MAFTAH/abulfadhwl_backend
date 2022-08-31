<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'number',
        'title',
        'description',
        'pub_year',
        'file',
    ];

    protected $dates=[
        'deleted_at'
    ];
}
