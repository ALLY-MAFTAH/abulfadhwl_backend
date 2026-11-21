<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Stream extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable=[
        'url',
        'timetable',
        'title',
        'description',
        'status',
        'day',
        'teacher',
        'time_label',
        'book',
        'translations',
        'position',
    ];
    public const DAYS = ['mon' => 'Jumatatu', 'tue' => 'Jumanne', 'wed' => 'Jumatano', 'thu' => 'Alhamisi', 'fri' => 'Ijumaa', 'sat' => 'Jumamosi', 'sun' => 'Jumapili'];

    /** Streams in timetable order: weekday, then the order the admin gave. Un-dayed lessons go last. */
    public static function timetableOrder()
    {
        $idx = array_flip(array_keys(self::DAYS));
        return static::all()->sortBy(fn ($s) => [$idx[$s->day] ?? 99, (int) $s->position, $s->id])->values();
    }

    protected $casts = ['translations' => 'array'];

    protected $dates=[
        'deleted_at'
    ];
}
