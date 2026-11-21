<?php

namespace App\Rules;

use App\Support\InputRules;
use Illuminate\Contracts\Validation\Rule;

/** Ordinary text only: no HTML tags and no obvious SQL/script injection payload. */
class PlainText implements Rule
{
    public function passes($attribute, $value): bool
    {
        if ($value === null) {
            return true;
        }
        return is_scalar($value) && !InputRules::looksUnsafe((string) $value);
    }

    public function message(): string
    {
        return 'Maandishi haya yana alama au maneno yasiyoruhusiwa (HTML au msimbo). Tafadhali yaandike kwa maneno ya kawaida.';
    }
}
