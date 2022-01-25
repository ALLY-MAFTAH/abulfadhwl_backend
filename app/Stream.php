<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stream extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'url',
        'timetable',
        'title',
        'description',
        'status'
    ];
    protected $dates=[
        'deleted_at'
    ];
}
