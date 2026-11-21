<?php

namespace App\Rules;

use App\Support\InputRules;
use Illuminate\Contracts\Validation\Rule;

/**
 * A title or name that is also used as a file or folder name (books, articles,
 * albums, categories, audio): plain text, and no slashes, NUL bytes or leading
 * dot, so it can never point outside its folder.
 */
class SafeName implements Rule
{
    public function passes($attribute, $value): bool
    {
        if (!is_scalar($value)) {
            return false;
        }
        $v = (string) $value;
        if (InputRules::looksUnsafe($v)) {
            return false;
        }
        return !preg_match('/[\/\\\\\x00]/', $v) && !str_starts_with(trim($v), '.');
    }

    public function message(): string
    {
        return 'Jina haliwezi kuwa na alama / au \\ , wala kuanza na nukta, wala msimbo wa HTML.';
    }
}
