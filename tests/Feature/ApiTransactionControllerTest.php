<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ApiTransactionControllerTest extends TestCase
{
    // 1. Given => teniendo, el estado antes de la accion que queremos realizar
    //Data
    protected static $id = 1;
    protected static $data = [
        'user_id' => 1,
        'origin_cost_center_id' => 1,
        'destiny_cost_center_id' => 2,
        'employee_id' => 3,
        'expense_concept_id' => 1,
        'transaction_type' => 'Efectivo',
        'amount' => 1,
        'date_time' => '2023-07-27',
        'notes' => 'notes_test',
    ];

    /**     @test     */
    public function store_error_data_empty()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/transaction', [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee("El campo user id es obligatorio.")
            ->assertSee("El campo origin cost center id es obligatorio.")
            ->assertSee("El campo destiny cost center id es obligatorio.")
            ->assertSee("El campo employee id es obligatorio.")
            ->assertSee("El campo expense concept id es obligatorio.")
            ->assertSee("El campo transaction type es obligatorio.")
            ->assertSee("El campo amount es obligatorio.")
            ->assertSee("El campo date time es obligatorio.")
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function store_ok()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/transaction', self::$data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful store!')
            ->assertSee('notes_test')
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**     @test     */
    public function store_error_forbidden_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/transaction', self::$data, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**     @test     */
    public function store_error_forbidden_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/transaction', self::$data, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**     @test     */
    public function store_error_forbidden_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/transaction', self::$data, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function show_ok()
    {
        self::$id = DB::table('transactions')->latest()->first()->id;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/transaction/' . self::$id, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get!')
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function show_fail_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/transaction/' . self::$id, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function show_fail_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/transaction/' . self::$id, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function show_fail_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/transaction/' . self::$id, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function update_just_one_field_ok()
    {
        $updated_data = [
            'amount' => 1.99,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/transaction/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(1.99)            //campo nuevo
            ->assertSee('notes_test')                              //campo anterior
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function update_forbidden_for_tierra()
    {
        $updated_data = [
            'name' => 'new_name_test_updated',
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/transaction/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function update_forbidden_for_aire()
    {
        $updated_data = [
            'name' => 'new_name_test_updated',
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/transaction/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function update_forbidden_for_milagros()
    {
        $updated_data = [
            'name' => 'new_name_test_updated',
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/transaction/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function update_ok()
    {
        $updated_data = [
            'user_id' => 1,
            'origin_cost_center_id' => 2,
            'destiny_cost_center_id' => 3,
            'employee_id' => 4,
            'expense_concept_id' => 2,
            'transaction_type' => 'Activo',
            'amount' => 1.01,
            'date_time' => '2023-07-28',
            'notes' => 'notes_test_up',
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/transaction/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(1)
            ->assertSee(2)
            ->assertSee(3)
            ->assertSee(4)
            ->assertSee(2)
            ->assertSee('Activo')
            ->assertSee(1.01)
            ->assertSee('2023-07-28')
            ->assertSee('notes_test_up')
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function index_datatables_ok()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/transaction?page=1', ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get')
            ->assertSee('notes_test_up')
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function index_datatables_error_forbidden_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/transaction?page=1', ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function index_datatables_error_forbidden_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/transaction?page=1', ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function index_datatables_error_forbidden_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/transaction?page=1', ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete_forbidden_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/transaction/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete_forbidden_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/transaction/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete_forbidden_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/transaction/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete_ok()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/transaction/' . self::$id, [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful delete!')
            ->assertStatus(Response::HTTP_OK);
    }
}
