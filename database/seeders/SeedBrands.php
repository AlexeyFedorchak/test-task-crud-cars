<?php

namespace Database\Seeders;

use App\Models\CarBrand;
use Illuminate\Database\Seeder;

class SeedBrands extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CarBrand::updateOrCreate([
            'name' => 'Tesla',
        ]);

        CarBrand::updateOrCreate([
            'name' => 'BMW',
        ]);

        CarBrand::updateOrCreate([
            'name' => 'Ford',
        ]);
    }
}
