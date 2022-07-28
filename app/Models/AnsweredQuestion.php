<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnsweredQuestion extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'qn',
        'textAns',
        'audioAns',
    ];

    protected $dates=[
        'deleted_at'
    ];
}
