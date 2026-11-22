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

    /** Weekday key (mon..sun) for "today" in the congregation's timezone (East Africa). */
    public static function todayKey(): string
    {
        return strtolower(now('Africa/Dar_es_Salaam')->format('D'));
    }

    /** The lesson scheduled for today (first in timetable order), or null. */
    public static function forToday(): ?self
    {
        return static::where('day', self::todayKey())->orderBy('position')->orderBy('id')->first();
    }

    protected $casts = ['translations' => 'array'];

    protected $dates=[
        'deleted_at'
    ];
}
