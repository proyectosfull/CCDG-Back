<?php

namespace Database\Seeders;

use App\Models\SubcostCenter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubcostCentersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('subcost_centers')->truncate();
        // Subcentro de Costos
        SubcostCenter::create(['name' => 'Distrito 1']);
        SubcostCenter::create(['name' => 'Distrito 2']);
        SubcostCenter::create(['name' => 'Distrito 3']);
        SubcostCenter::create(['name' => 'Distrito 4']);
        SubcostCenter::create(['name' => 'Distrito 5']);
        SubcostCenter::create(['name' => 'Distrito 6']);
        SubcostCenter::create(['name' => 'Distrito 7']);
        SubcostCenter::create(['name' => 'Distrito 8']);
        SubcostCenter::create(['name' => 'Distrito 9']);
        SubcostCenter::create(['name' => 'Distrito 10']);
        SubcostCenter::create(['name' => 'Distrito 11']);
        SubcostCenter::create(['name' => 'Distrito 12']);
        SubcostCenter::create(['name' => 'Distrito 13']);
        SubcostCenter::create(['name' => 'Distrito 14']);
        SubcostCenter::create(['name' => 'Distrito 15']);
    }
}
