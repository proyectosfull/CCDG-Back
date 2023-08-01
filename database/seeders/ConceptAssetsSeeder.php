<?php

namespace Database\Seeders;

use App\Models\ConceptAsset;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConceptAssetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('concept_assets')->truncate();
        ConceptAsset::create(['name' => 'Automóviles']);
        ConceptAsset::create(['name' => 'Equipo Computo']);
        ConceptAsset::create(['name' => 'Gasolina']);
    }
}
