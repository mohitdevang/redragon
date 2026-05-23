<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('countries')) {
            return;
        }

        DB::table('countries')->orderBy('id')->chunkById(100, function ($rows) {
            foreach ($rows as $row) {
                $digits = preg_replace('/\D+/', '', (string) $row->dial_code);
                if ($digits === '') {
                    continue;
                }
                DB::table('countries')->where('id', $row->id)->update([
                    'dial_code' => '+'.$digits,
                ]);
            }
        });
    }

    public function down(): void
    {
        // Non-reversible without backup.
    }
};
