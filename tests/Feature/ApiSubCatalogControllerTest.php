<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ApiSubCatalogControllerTest extends TestCase
{
    // 1. Given => teniendo, el estado antes de la accion que queremos realizar
    //Data
    protected static $id = 1;
    protected static $data = [
        'name' => 'name_test',
        'description' => 'description_test',
        'catalog_id' => 40,
    ];

    /**
     * Error. @test
     */
    public function store_error_data_empty()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/subcatalog', [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee("El campo name es obligatorio.")
            ->assertSee("El campo catalog id es obligatorio.")
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Error. @test
     */
    public function store_error_foreign_key_does_not_exists()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/subcatalog', self::$data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee("El campo catalog id seleccionado no existe.")
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Creacion normal. @test
     */
    public function store_ok()
    {
        self::$data['catalog_id'] = 1;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/subcatalog', self::$data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful store!')
            ->assertSee('name_test')
            ->assertSee('description_test')
            ->assertSee(1)
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * Creacion normal. @test
     */
    public function store_error_name_already_exists()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/subcatalog', self::$data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('El valor del campo name ya est') //á en uso.
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * store error. @test
     */
    public function store_error_forbidden_for_operator()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/subcatalog', self::$data, ['Authorization' => env('TOKEN_TEST_OPE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Show normal. @test
     */
    public function show_ok()
    {
        self::$id = DB::table('subcatalogs')->latest()->first()->id;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/subcatalog/' . self::$id, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get!')
            ->assertSee('name_test')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Show normal. @test
     */
    public function show_ok_for_operator()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/subcatalog/' . self::$id, ['Authorization' => env('TOKEN_TEST_OPE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('name_test')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Update normal. @test
     */
    public function update_just_one_field_ok()
    {
        $updated_data = [
            'description' => 'description_updated',
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/subcatalog/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee('name_test')                        //campo nuevo
            ->assertSee('description_updated')              //campo anterior
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Update error. @test
     */
    public function update_forbidden_for_operator()
    {
        $updated_data = [
            'description' => 'description_updated',
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/subcatalog/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_OPE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Update normal. @test
     */
    public function update_ok()
    {
        $updated_data = [
            'name' => 'name_test_updated',
            'description' => 'description_test',
            'catalog_id' => 4,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/subcatalog/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee('name_test_updated')
            ->assertSee('description_test')
            ->assertSee(4)
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Datatables normal. @test
     */
    public function index_datatables_ok()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/subcatalog?page=1', ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get')
            ->assertSee('name_test_updated')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Datatables normal. @test
     */
    public function index_datatables_ok_for_operator()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/subcatalog?page=1', ['Authorization' => env('TOKEN_TEST_OPE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get')
            ->assertSee('name_test_updated')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * delete error. @test
     */
    public function delete_forbidden_for_operator()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/subcatalog/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_OPE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * delete normal. @test
     */
    public function delete_error_forbidden_for_operator()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/subcatalog/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_OPE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertForbidden();
    }

    /**
     * delete normal. @test
     */
    public function delete_ok()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/subcatalog/' . self::$id, [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful delete!')
            ->assertStatus(Response::HTTP_OK);
    }
}
