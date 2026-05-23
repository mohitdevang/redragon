<?php

namespace App\Support;

class CountryDial
{
    public static function normalize(?string $dial): string
    {
        $digits = preg_replace('/\D+/', '', (string) $dial);

        return $digits === '' ? '' : '+'.$digits;
    }

    public static function digits(?string $dial): string
    {
        return preg_replace('/\D+/', '', (string) $dial);
    }

    public static function flagEmoji(?string $isoCode): string
    {
        $iso = strtoupper(substr((string) $isoCode, 0, 2));
        if (strlen($iso) !== 2 || ! ctype_alpha($iso)) {
            return '';
        }

        $chars = str_split($iso);

        return mb_chr(0x1F1E6 + ord($chars[0]) - 65, 'UTF-8')
            .mb_chr(0x1F1E6 + ord($chars[1]) - 65, 'UTF-8');
    }
}
