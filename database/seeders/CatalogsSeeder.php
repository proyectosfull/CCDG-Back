<?php

namespace Database\Seeders;

use App\Models\Catalog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('catalogs')->truncate();
        Catalog::create(['name' => 'Centro de costo', 'description' => '']);
        Catalog::create(['name' => 'Concepto de costo', 'description' => '']);
        Catalog::create(['name' => 'Nómina tierra', 'description' => '']);
        Catalog::create(['name' => 'Control de activos', 'description' => '']);
        Catalog::create(['name' => 'Subcentro de costos', 'description' => '']);
        Catalog::create(['name' => 'Inventarios', 'description' => '']);
    }
}