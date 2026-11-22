<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HijriMonth extends Model
{
    protected $fillable = ['hijri_year', 'hijri_month', 'starts_on', 'note'];

    protected $casts = [
        'hijri_year' => 'integer',
        'hijri_month' => 'integer',
        'starts_on' => 'date:Y-m-d',
    ];

    public const NAMES = [
        1 => 'Muharram', 2 => 'Swafar', 3 => 'Rabiul Awwal', 4 => 'Rabiul Thaani',
        5 => 'Jumaadal Uulaa', 6 => 'Jumaadal Aakhira', 7 => 'Rajab', 8 => 'Shaaban',
        9 => 'Ramadhani', 10 => 'Shawwaal', 11 => "Dhul Qa'dah", 12 => 'Dhul Hijjah',
    ];
}
