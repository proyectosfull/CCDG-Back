<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ApiEmployeeControllerTest extends TestCase
{
    // 1. Given => teniendo, el estado antes de la accion que queremos realizar
    //Data
    protected static $id = 1;
    protected static $data = [
        'full_name' => 'full_name_test',
        'phone_number' => '124578124578',
        'email' => 'email@ccdg.com',
    ];

    /**     @test     */
    public function store_error_data_empty()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/employee', [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee("El campo full name es obligatorio.")
            ->assertSee("El campo email es obligatorio.")
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function store_ok()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/employee', self::$data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful store!')
            ->assertSee('full_name_test')
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**      @test    //  */
    public function store_error_name_already_exists()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/employee', self::$data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('El valor del campo email ya est') //á en uso.
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function store_error_forbidden_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/employee', self::$data, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**     @test     */
    public function store_error_forbidden_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/employee', self::$data, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**     @test     */
    public function store_error_forbidden_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/employee', self::$data, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function show_ok()
    {
        self::$id = DB::table('employees')->latest()->first()->id;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/employee/' . self::$id, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get!')
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function show_fail_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/employee/' . self::$id, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function show_fail_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/employee/' . self::$id, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function show_fail_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/employee/' . self::$id, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function update_just_one_field_ok()
    {
        $updated_data = [
            'full_name' => 'full_name_test_updated',
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/employee/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee('full_name_test_updated')            //campo nuevo
            ->assertSee('email@ccdg.com')                              //campo anterior
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function update_forbidden_for_tierra()
    {
        $updated_data = [
            'full_name' => 'full_name_test_updated',
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/employee/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function update_forbidden_for_aire()
    {
        $updated_data = [
            'full_name' => 'full_name_test_updated',
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/employee/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function update_forbidden_for_milagros()
    {
        $updated_data = [
            'full_name' => 'full_name_test_updated',
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/employee/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function update_ok()
    {
        $updated_data = [
            'full_name' => 'full_name_test',
            'phone_number' => '124578124599',
            'email' => 'email1@ccdg.com',
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/employee/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee('full_name_test')
            ->assertSee('124578124599')
            ->assertSee('email1@ccdg.com')
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function index_datatables_ok()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/employee?page=1', ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get')
            ->assertSee('full_name_test')
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function index_datatables_error_forbidden_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/employee?page=1', ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function index_datatables_error_forbidden_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/employee?page=1', ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function index_datatables_error_forbidden_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/employee?page=1', ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete_forbidden_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/employee/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete_forbidden_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/employee/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete_forbidden_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/employee/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete_ok()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/employee/' . self::$id, [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful delete!')
            ->assertStatus(Response::HTTP_OK);
    }
}
