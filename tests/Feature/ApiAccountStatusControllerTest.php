<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ApiAccountStatusControllerTest extends TestCase
{
    // 1. Given => teniendo, el estado antes de la accion que queremos realizar
    //Data
    protected static $id = 1;
    protected static $data = [
        'cost_center_id' => 30,
        'current_stock' => 10,
        'concept_asset_id' => 30,
    ];

    /**     @test     */
    public function store_error_data_empty()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/account-status', [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee("El campo cost center id es obligatorio.")
            ->assertSee("El campo current stock es obligatorio.")
            ->assertSee("El campo concept asset id es obligatorio.")
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function store_error_foreign_keys_does_not_exists()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/account-status', self::$data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee("El campo cost center id seleccionado no existe.")
            ->assertSee("El campo concept asset id seleccionado no existe.")
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function store_ok_for_tierra()
    {
        self::$data['cost_center_id'] = 1;
        self::$data['concept_asset_id'] = 1;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/account-status', self::$data, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful store!')
            ->assertSee(10)
            ->assertSee(1)
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**     @test     */
    public function store_error_forbidden_for_tierra()
    {
        self::$data['cost_center_id'] = 2;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/account-status', self::$data, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function show_ok_for_tierra()
    {
        self::$id = DB::table('account_statuses')->latest()->first()->id;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/account-status/' . self::$id, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get!')
            ->assertSee(10)
            ->assertSee(1)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function update_just_one_field_ok_for_tierra()
    {
        $updated_data = [
            'current_stock' => 11,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/account-status/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(1)                      //campo nuevo
            ->assertSee(11)                     //campo anterior
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function update_forbidden_for_tierra()
    {
        $updated_data = [
            'cost_center_id' => 2,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/account-status/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function update_ok_for_tierra()
    {
        $updated_data = [
            'current_stock' => 12,
            'concept_asset_id' => 3,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/account-status/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(1)
            ->assertSee(12)
            ->assertSee(3)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function index_datatables_ok_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/account-status?page=1', ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get')
            ->assertSee(12)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function delete_forbidden_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/account-status/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete_ok_for_admin()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/account-status/' . self::$id, [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful delete!')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * 
     * AIRE
     * 
     */

    /**     @test     */
    public function store_ok_for_aire()
    {
        self::$data['cost_center_id'] = 2;
        self::$data['concept_asset_id'] = 1;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/account-status', self::$data, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful store!')
            ->assertSee(10)
            ->assertSee(1)
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**     @test     */
    public function store_error_forbidden_for_aire()
    {
        self::$data['cost_center_id'] = 4;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/account-status', self::$data, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function show_ok_for_aire()
    {
        self::$id = DB::table('account_statuses')->latest()->first()->id;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/account-status/' . self::$id, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get!')
            ->assertSee(10)
            ->assertSee(1)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function update_just_one_field_ok_for_aire()
    {
        $updated_data = [
            'current_stock' => 11,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/account-status/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(1)                      //campo nuevo
            ->assertSee(11)                     //campo anterior
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function update_forbidden_for_aire()
    {
        $updated_data = [
            'cost_center_id' => 4,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/account-status/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function update_ok_for_aire()
    {
        $updated_data = [
            'current_stock' => 12,
            'concept_asset_id' => 3,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/account-status/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(1)
            ->assertSee(12)
            ->assertSee(3)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function index_datatables_ok_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/account-status?page=1', ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get')
            ->assertSee(12)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function delete_forbidden_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/account-status/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete2_ok_for_admin()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/account-status/' . self::$id, [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful delete!')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * 
     * MILAGROS
     * 
     */

    /**     @test     */
    public function store_ok_for_milagros()
    {
        self::$data['cost_center_id'] = 4;
        self::$data['concept_asset_id'] = 1;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/account-status', self::$data, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful store!')
            ->assertSee(10)
            ->assertSee(1)
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**     @test     */
    public function store_error_forbidden_for_milagros()
    {
        self::$data['cost_center_id'] = 3;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/account-status', self::$data, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function show_ok_for_milagros()
    {
        self::$id = DB::table('account_statuses')->latest()->first()->id;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/account-status/' . self::$id, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get!')
            ->assertSee(10)
            ->assertSee(1)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function update_just_one_field_ok_for_milagros()
    {
        $updated_data = [
            'current_stock' => 11,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/account-status/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(11)                      //campo nuevo
            ->assertSee(1)                     //campo anterior
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function update_forbidden_for_milagros()
    {
        $updated_data = [
            'cost_center_id' => 3,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/account-status/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function update_ok_for_milagros()
    {
        $updated_data = [
            'current_stock' => 12,
            'concept_asset_id' => 3,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/account-status/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(3)
            ->assertSee(12)
            ->assertSee(3)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function index_datatables_ok_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/account-status?page=1', ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get')
            ->assertSee(12)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function delete_forbidden_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/account-status/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete3_ok_for_admin()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/account-status/' . self::$id, [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful delete!')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * 
     * ADMIN
     * 
     */

    /**     @test     */
    public function store_ok_for_administracion()
    {
        self::$data['cost_center_id'] = 3;
        self::$data['concept_asset_id'] = 1;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/account-status', self::$data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful store!')
            ->assertSee(10)
            ->assertSee(1)
            ->assertSee(3)
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**     @test     */
    public function show_ok_for_administracion()
    {
        self::$id = DB::table('account_statuses')->latest()->first()->id;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/account-status/' . self::$id, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get!')
            ->assertSee(10)
            ->assertSee(1)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function update_just_one_field_ok_for_administracion()
    {
        $updated_data = [
            'cost_center_id' => 1,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/account-status/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(1)                      //campo nuevo
            ->assertSee(10)                     //campo anterior
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function update_ok_for_administracion()
    {
        $updated_data = [
            'current_stock' => 12,
            'cost_center_id' => 2,
            'concept_asset_id' => 3,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/account-status/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(2)
            ->assertSee(12)
            ->assertSee(3)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function index_datatables_ok_for_administracion()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/account-status?page=1', ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get')
            ->assertSee(12)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function delete_ok_for_administracion()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/account-status/' . self::$id, [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful delete!')
            ->assertStatus(Response::HTTP_OK);
    }
}
