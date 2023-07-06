<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ApiUserControllerTest extends TestCase
{
    // 1. Given => teniendo, el estado antes de la accion que queremos realizar
    //Data
    protected static $id = 1;
    protected static $data = [
        'name' => 'name_test',
        'email' => 'email_test@test.com',
        'password' => 'password_test',
        'role' => 'operadora',
    ];

    /**
     * Error. @test
     */
    public function store_error_data_empty()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/user', [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee("El campo email es obligatorio.")
            ->assertSee("El campo name es obligatorio.")
            ->assertSee("El campo password es obligatorio.")
            ->assertSee("El campo role es obligatorio.")
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Error. @test
     */
    public function store_error_foreign_does_not_exists()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/user', self::$data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('El campo role seleccionado no existe.')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Creacion normal. @test
     */
    public function store_ok()
    {
        self::$data['role'] = 'operador';
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/user', self::$data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful store!')
            ->assertSee('name_test')
            ->assertSee('operador')
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * error store. @test
     */
    public function store_error_email_already_exists()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/user', self::$data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('El valor del campo email ya est')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Creacion normal. @test
     */
    public function store_forbidden_for_operator()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/user', self::$data, ['Authorization' => env('TOKEN_TEST_OPE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Show normal. @test
     */
    public function show_ok()
    {
        self::$id = DB::table('users')->latest()->first()->id;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/user/' . self::$id, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get!')
            ->assertSee('name_test')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * show normal. @test
     */
    public function show_forbidden_for_operator()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/user/' . self::$id, ['Authorization' => env('TOKEN_TEST_OPE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * Update normal. @test
     */
    public function update_just_one_field_ok()
    {
        $updated_data = [
            'name' => 'name_test_up',
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/user/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee('name_test_up')                     //campo nuevo
            ->assertSee('email_test@test.com')              //campo anterior
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Update normal. @test
     */
    public function update_forbidden_for_operator()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/user/' . self::$id, ['name' => 'name_test_up'], ['Authorization' => env('TOKEN_TEST_OPE')]);
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
            'name' => 'name_test',
            'email' => 'email_test_up@test.com',
            'password' => 'password_test_up',
            'role' => 'administrador',
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/user/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee('name_test')
            ->assertSee('email_test_up@test.com')
            ->assertSee('administrador')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Datatables normal. @test
     */
    public function index_datatables_ok()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/user', ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('email_test_up@test.com')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Datatables normal. @test
     */
    public function index_datatables_forbidden_for_operator()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/user', ['Authorization' => env('TOKEN_TEST_OPE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * delete normal. @test
     */
    public function delete_forbidden_for_operator()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/user/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_OPE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * delete normal. @test
     */
    public function delete_ok()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/user/' . self::$id, [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful delete!')
            ->assertStatus(Response::HTTP_OK);
    }
}
