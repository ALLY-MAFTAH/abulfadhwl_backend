<?php

namespace App\Support;

/**
 * One place for the input checks used by the public API (contact, questions)
 * and the admin forms. SQL injection is already prevented by Eloquent (every
 * value is a bound parameter, and no raw SQL is built from input); these checks
 * add a second wall and keep junk out of the database.
 */
class InputRules
{
    /** Country calling codes (E.164). Used to tell a real number from digits. */
    private const CODES = [1,7,20,27,30,31,32,33,34,36,39,40,41,43,44,45,46,47,48,49,51,52,53,54,55,56,57,58,60,61,62,63,64,65,66,81,82,84,86,90,91,92,93,94,95,98,211,212,213,216,218,220,221,222,223,224,225,226,227,228,229,230,231,232,233,234,235,236,237,238,239,240,241,242,243,244,245,246,247,248,249,250,251,252,253,254,255,256,257,258,260,261,262,263,264,265,266,267,268,269,290,291,297,298,299,350,351,352,353,354,355,356,357,358,359,370,371,372,373,374,375,376,377,378,379,380,381,382,383,385,386,387,389,420,421,423,500,501,502,503,504,505,506,507,508,509,590,591,592,593,594,595,596,597,598,599,670,672,673,674,675,676,677,678,679,680,681,682,683,685,686,687,688,689,690,691,692,850,852,853,855,856,880,886,960,961,962,963,964,965,966,967,968,970,971,972,973,974,975,976,977,992,993,994,995,996,998];

    /** Clear attack payloads. Deliberately narrow so normal sentences never match. */
    private const ATTACK = '/(\bunion\b\s+(all\s+)?select\b|\bdrop\s+(table|database)\b|\binsert\s+into\b|\bdelete\s+from\b|\bupdate\s+\w+\s+set\b|;\s*--|\bor\s+[\'"]?1[\'"]?\s*=\s*[\'"]?1\b|\bsleep\s*\(|\bbenchmark\s*\(|<\s*script|javascript\s*:|onerror\s*=|onload\s*=)/i';

    /** Removes control characters and null bytes, trims, collapses spaces (keeps line breaks). */
    public static function cleanText(?string $s): string
    {
        $s = (string) $s;
        $s = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $s) ?? '';
        $s = preg_replace('/[ \t]{2,}/u', ' ', $s) ?? '';
        $s = preg_replace('/\n{3,}/u', "\n\n", $s) ?? '';
        return trim($s);
    }

    /** True when the text has HTML tags or an obvious injection payload. */
    public static function looksUnsafe(?string $s): bool
    {
        $s = (string) $s;
        if (preg_match('/<\s*\/?\s*[a-z!][^>]*>/i', $s)) {
            return true;
        }
        return (bool) preg_match(self::ATTACK, $s);
    }

    /** A person's name: letters (any script), marks, spaces, . ' - ; 2-100 chars. */
    public static function isPersonName(?string $s): bool
    {
        $s = trim((string) $s);
        return mb_strlen($s) >= 2 && mb_strlen($s) <= 100
            && (bool) preg_match("/^[\p{L}\p{M}][\p{L}\p{M}\s.'’\-]*$/u", $s);
    }

    /**
     * International phone number to E.164 ("+255712345678"), or null when it is
     * not a plausible real number. Accepts "+", "00" or no prefix, spaces, dashes,
     * dots and brackets. A leading 0 is read as a Tanzanian local number.
     */
    public static function normalizePhone(?string $raw): ?string
    {
        $s = trim((string) $raw);
        if ($s === '' || preg_match('/[^0-9+\s\-().]/', $s)) {
            return null;
        }
        $plus = str_starts_with($s, '+');
        $digits = preg_replace('/\D/', '', $s) ?? '';
        if ($plus === false && str_starts_with($digits, '00')) {
            $digits = substr($digits, 2);
            $plus = true;
        }
        if (strpos(ltrim($s, '+'), '+') !== false) {
            return null; // a plus in the middle
        }
        if ($plus === false && str_starts_with($digits, '0') && strlen($digits) === 10) {
            $digits = '255' . substr($digits, 1); // 0712 345 678 -> +255712345678
        } elseif ($plus === false && strlen($digits) === 9 && in_array($digits[0], ['6', '7'], true)) {
            $digits = '255' . $digits;
        }
        if (strlen($digits) < 8 || strlen($digits) > 15 || $digits[0] === '0') {
            return null;
        }
        // Calling code: 1, 2 or 3 digits, from the list.
        $national = null;
        foreach ([1, 2, 3] as $n) {
            if (in_array((int) substr($digits, 0, $n), self::CODES, true) && strlen($digits) > $n) {
                $cc = substr($digits, 0, $n);
                $rest = substr($digits, $n);
                if (strlen($rest) >= 4 && strlen($rest) <= 12) {
                    $national = $rest;
                    if ($cc === '1' && (strlen($rest) !== 10 || $rest[0] < '2')) {
                        $national = null; // North America: 10 digits, area code 2-9
                        continue;
                    }
                    break;
                }
            }
        }
        if ($national === null) {
            return null;
        }
        // Junk like 1111111111 or 1234567890.
        if (preg_match('/^(\d)\1+$/', $national) || strpos('01234567890', $national) !== false || strpos('09876543210', $national) !== false) {
            return null;
        }
        return '+' . $digits;
    }
}
