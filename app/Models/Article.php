<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $fillable=[
        'number',
        'title',
        'description',
        'pub_year',
        'file',
    ];
}
