<?php

namespace App\Support;

use Illuminate\Http\Request;

/** Admin-written content in extra languages (Kiswahili is the base). */
class Translations
{
    public const LANGS = ['en' => 'English', 'ar' => 'العربية'];

    /**
     * Reads `tr[en][field]`, `tr[ar][field]` from the request. Empty values are
     * dropped, so a missing translation falls back to Kiswahili in the app.
     */
    public static function collect(Request $request, array $fields): ?array
    {
        $in = (array) $request->input('tr', []);
        $out = [];
        foreach (array_keys(self::LANGS) as $lang) {
            foreach ($fields as $f) {
                $v = trim((string) ($in[$lang][$f] ?? ''));
                if ($v !== '') $out[$lang][$f] = mb_substr($v, 0, 1000);
            }
        }
        return $out ?: null;
    }

    /** The text in $lang, or the Kiswahili original. */
    public static function pick($model, string $field, string $lang): string
    {
        $t = $model->translations[$lang][$field] ?? null;
        return $t !== null && $t !== '' ? (string) $t : (string) ($model->{$field} ?? '');
    }
}
