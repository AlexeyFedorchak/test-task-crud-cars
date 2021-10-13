<?php

namespace Database\Seeders;

use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class SeedModels extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (CarBrand::all() as $brand) {
            CarModel::updateOrCreate([
                'name' => 'test_model_' . rand(10, 99),
            ], [
                'brand_id' => $brand->id,
            ]);
        }
    }
}
