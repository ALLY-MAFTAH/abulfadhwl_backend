<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'name',
        'description',
        'category_id'
    ];

    protected $dates=[
        'deletedAt'
    ];

    /** What the app sees: active songs only, in the order the admin arranged. */
    public function songs()
    {
        $q = $this->hasMany(Song::class);
        if (self::hasSongColumns()) {
            $q->where('active', 1)->orderBy('position');
        }
        return $q->orderBy('title');
    }

    /** What the admin sees: every song, including the switched-off ones. */
    public function allSongs()
    {
        $q = $this->hasMany(Song::class);
        if (self::hasSongColumns()) {
            $q->orderBy('position');
        }
        return $q->orderBy('title');
    }

    /** Safe before the migration has run on a server. */
    private static function hasSongColumns(): bool
    {
        static $has = null;
        return $has ??= \Illuminate\Support\Facades\Schema::hasColumn('songs', 'active');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
