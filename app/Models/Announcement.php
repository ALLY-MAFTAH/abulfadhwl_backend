<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'news',
        'date',
        'translations',
    ];

    protected $casts = ['translations' => 'array'];
    protected $dates=[
        'deleted_at'
    ];
}
