<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

class RegistrationSerialAllocator
{
    public static function next(): int
    {
        return (int) DB::transaction(function () {
            $max = (int) DB::table('users')->lockForUpdate()->max('registration_serial');

            return $max + 1;
        });
    }
}
