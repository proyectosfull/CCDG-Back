<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ApiConceptExpenseByUserControllerTest extends TestCase
{
    // 1. Given => teniendo, el estado antes de la accion que queremos realizar
    //Data
    protected static $id = 1;
    protected static $data = [
        'user_id' => 100,
        'expense_concept_id' => 100,

    ];

    /**     @test     */
    public function store_error_data_empty()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/concept-expense-by-user', [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee("El campo user id es obligatorio.")
            ->assertSee("El campo expense concept id es obligatorio.")
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function store_error_foreign_keys_does_not_exists()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/concept-expense-by-user', self::$data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee("El campo user id seleccionado no existe.")
            ->assertSee("El campo expense concept id seleccionado no existe.")
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function store_ok()
    {
        self::$data['user_id'] = 1;
        self::$data['expense_concept_id'] = 1;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/concept-expense-by-user', self::$data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful store!')
            ->assertStatus(Response::HTTP_CREATED);
    }

    // /**      @test      */
    // public function store_error_name_already_exists()
    // {
    //     //2. When => Cuando, realizamos dicha accion
    //     $response = $this->post('/api/concept-expense-by-user', self::$data, ['Authorization' => env('TOKEN_TEST')]);
    //     //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
    //     $response
    //         ->assertSee('El valor del campo name ya est') //á en uso.
    //         ->assertStatus(Response::HTTP_OK);
    // }

    /**     @test     */
    public function store_error_forbidden_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/concept-expense-by-user', self::$data, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**     @test     */
    public function store_error_forbidden_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/concept-expense-by-user', self::$data, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**     @test     */
    public function store_error_forbidden_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/concept-expense-by-user', self::$data, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function show_ok()
    {
        self::$id = DB::table('concept_expense_by_users')->latest()->first()->id;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/concept-expense-by-user/' . self::$id, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get!')
            ->assertSee('Tierra')
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function show_fail_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/concept-expense-by-user/' . self::$id, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function show_fail_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/concept-expense-by-user/' . self::$id, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function show_fail_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/concept-expense-by-user/' . self::$id, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function update_just_one_field_ok()
    {
        $updated_data = [
            'user_id' => 2,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/concept-expense-by-user/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(2)            //campo nuevo
            ->assertSee(1)                              //campo anterior
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function update_forbidden_for_tierra()
    {
        $updated_data = [
            'user_id' => 2,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/concept-expense-by-user/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function update_forbidden_for_aire()
    {
        $updated_data = [
            'user_id' => 2,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/concept-expense-by-user/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function update_forbidden_for_milagros()
    {
        $updated_data = [
            'user_id' => 2,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/concept-expense-by-user/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function update_ok()
    {
        $updated_data = [
            'user_id' => 1,
            'expense_concept_id' => 3, //Eventos
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/concept-expense-by-user/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(1)
            ->assertSee(3)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function index_datatables_ok()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/concept-expense-by-user?page=1', ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get')
            ->assertSee(1)
            ->assertSee('Eventos')
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function index_datatables_error_forbidden_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/concept-expense-by-user?page=1', ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function index_datatables_error_forbidden_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/concept-expense-by-user?page=1', ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function index_datatables_error_forbidden_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/concept-expense-by-user?page=1', ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete_forbidden_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/concept-expense-by-user/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete_forbidden_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/concept-expense-by-user/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete_forbidden_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/concept-expense-by-user/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete_ok()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/concept-expense-by-user/' . self::$id, [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful delete!')
            ->assertStatus(Response::HTTP_OK);
    }
}
