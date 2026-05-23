<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('countries')) {
            Schema::create('countries', function (Blueprint $table) {
                $table->id();
                $table->string('name', 120);
                $table->char('iso_code', 2)->unique();
                $table->char('iso3_code', 3)->nullable();
                $table->string('country_code', 8)->nullable();
                $table->string('dial_code', 8);
                $table->string('flag', 16)->nullable();
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
