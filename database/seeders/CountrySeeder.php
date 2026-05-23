<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $path = __DIR__.'/data/countries.php';
        if (! file_exists($path)) {
            $this->command?->warn('countries.php data file missing. Run: php database/seeders/build_countries_data.php');

            return;
        }

        $rows = require $path;

        foreach ($rows as $row) {
            [$iso, $name, $dial] = $row;
            Country::updateOrCreate(
                ['iso_code' => $iso],
                [
                    'name' => $name,
                    'iso3_code' => null,
                    'country_code' => $iso,
                    'dial_code' => $dial,
                    'flag' => strtolower($iso),
                    'status' => true,
                ]
            );
        }
    }
}
