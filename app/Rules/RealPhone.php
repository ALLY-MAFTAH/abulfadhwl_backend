<?php

namespace App\Rules;

use App\Support\InputRules;
use Illuminate\Contracts\Validation\Rule;

/** A real-looking phone number from any country (see InputRules::normalizePhone). */
class RealPhone implements Rule
{
    public function passes($attribute, $value): bool
    {
        return InputRules::normalizePhone(is_string($value) ? $value : null) !== null;
    }

    public function message(): string
    {
        return 'Namba ya simu si sahihi. Andika namba kamili, mfano 0712 345 678 au +1 415 555 2671.';
    }
}
