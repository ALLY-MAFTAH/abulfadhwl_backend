<?php

namespace App\Rules;

use App\Support\InputRules;
use Illuminate\Contracts\Validation\Rule;

/** A person's name: letters in any language, spaces, . ' - (2-100 characters). */
class PersonName implements Rule
{
    public function passes($attribute, $value): bool
    {
        return is_string($value) && InputRules::isPersonName($value);
    }

    public function message(): string
    {
        return 'Jina lazima liwe na herufi tu (mfano Ali Hassan), kati ya herufi 2 na 100.';
    }
}
