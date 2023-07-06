<?php

namespace Database\Seeders;

use App\Models\SubCatalog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCatalogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('subcatalogs')->truncate();
        // CENTRO DE COSTO id=1
        SubCatalog::create(['name' => 'Tierra', 'catalog_id' => 1, 'description' => '']);
        SubCatalog::create(['name' => 'Aire', 'catalog_id' => 1, 'description' => '']);
        SubCatalog::create(['name' => 'Administración', 'catalog_id' => 1, 'description' => '']);
        SubCatalog::create(['name' => 'Milagros', 'catalog_id' => 1, 'description' => '']);
        //ConceptoDeGasto id=2
        SubCatalog::create(['name' => 'Tierra', 'catalog_id' => 2, 'description' => '']);
        SubCatalog::create(['name' => 'Nómina', 'catalog_id' => 2, 'description' => '']);
        SubCatalog::create(['name' => 'Eventos', 'catalog_id' => 2, 'description' => '']);
        SubCatalog::create(['name' => 'Talleres', 'catalog_id' => 2, 'description' => '']);
        SubCatalog::create(['name' => 'Gasolina', 'catalog_id' => 2, 'description' => '']);
        SubCatalog::create(['name' => 'Aire', 'catalog_id' => 2, 'description' => '']);
        SubCatalog::create(['name' => 'Encuestas y Estudios', 'catalog_id' => 2, 'description' => '']);
        SubCatalog::create(['name' => 'Entregables', 'catalog_id' => 2, 'description' => '']);
        SubCatalog::create(['name' => 'Publicaciones', 'catalog_id' => 2, 'description' => '']);
        SubCatalog::create(['name' => 'Milagros', 'catalog_id' => 2, 'description' => '']);
        SubCatalog::create(['name' => 'Ejecutivos de Cuenta', 'catalog_id' => 2, 'description' => '']);
        SubCatalog::create(['name' => 'Otros', 'catalog_id' => 2, 'description' => '']);
        // NominaTierra id=3
        SubCatalog::create(['name' => 'Coordinacion General', 'catalog_id' => 3, 'description' => '']);
        SubCatalog::create(['name' => 'Staff Estatal', 'catalog_id' => 3, 'description' => '']);
        SubCatalog::create(['name' => 'Oficina Central', 'catalog_id' => 3, 'description' => '']);
        SubCatalog::create(['name' => 'Juridico', 'catalog_id' => 3, 'description' => '']);
        SubCatalog::create(['name' => 'Distritales', 'catalog_id' => 3, 'description' => '']);
        SubCatalog::create(['name' => 'Municipales', 'catalog_id' => 3, 'description' => '']);
        SubCatalog::create(['name' => 'Talleristas', 'catalog_id' => 3, 'description' => '']);
        SubCatalog::create(['name' => 'Seguridad/Movilización', 'catalog_id' => 3, 'description' => '']);
        SubCatalog::create(['name' => 'Agenda', 'catalog_id' => 3, 'description' => '']);
        SubCatalog::create(['name' => 'Otros', 'catalog_id' => 3, 'description' => '']);
        SubCatalog::create(['name' => 'Alerta Violeta', 'catalog_id' => 3, 'description' => '']);
        // Control Activos
        SubCatalog::create(['name' => 'Automóviles', 'catalog_id' => 4, 'description' => '']);
        SubCatalog::create(['name' => 'Equipo Computo', 'catalog_id' => 4, 'description' => '']);
        SubCatalog::create(['name' => 'Gasolina', 'catalog_id' => 4, 'description' => '']);
        // Subcentro de Costos
        SubCatalog::create(['name' => 'Distrito 1', 'catalog_id' => 5, 'description' => '']);
        SubCatalog::create(['name' => 'Distrito 2', 'catalog_id' => 5, 'description' => '']);
        SubCatalog::create(['name' => 'Distrito 3', 'catalog_id' => 5, 'description' => '']);
        SubCatalog::create(['name' => 'Distrito 4', 'catalog_id' => 5, 'description' => '']);
        SubCatalog::create(['name' => 'Distrito 5', 'catalog_id' => 5, 'description' => '']);
        SubCatalog::create(['name' => 'Distrito 6', 'catalog_id' => 5, 'description' => '']);
        SubCatalog::create(['name' => 'Distrito 7', 'catalog_id' => 5, 'description' => '']);
        SubCatalog::create(['name' => 'Distrito 8', 'catalog_id' => 5, 'description' => '']);
        SubCatalog::create(['name' => 'Distrito 9', 'catalog_id' => 5, 'description' => '']);
        SubCatalog::create(['name' => 'Distrito 10', 'catalog_id' => 5, 'description' => '']);
        SubCatalog::create(['name' => 'Distrito 11', 'catalog_id' => 5, 'description' => '']);
        SubCatalog::create(['name' => 'Distrito 12', 'catalog_id' => 5, 'description' => '']);
        SubCatalog::create(['name' => 'Distrito 13', 'catalog_id' => 5, 'description' => '']);
        SubCatalog::create(['name' => 'Distrito 14', 'catalog_id' => 5, 'description' => '']);
        SubCatalog::create(['name' => 'Distrito 15', 'catalog_id' => 5, 'description' => '']);
        // Inventarios
    }
}


