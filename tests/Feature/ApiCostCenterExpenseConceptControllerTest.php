<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ApiCostCenterExpenseConceptControllerTest extends TestCase
{
    // 1. Given => teniendo, el estado antes de la accion que queremos realizar
    //Data
    protected static $id = 1;
    protected static $data = [
        'cost_center_id' => 100,
        'expense_concept_id' => 100,
    ];

    /**     @test     */
    public function store_error_data_empty()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/cost-center-expense-concept', [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee("El campo cost center id es obligatorio.")
            ->assertSee("El campo expense concept id es obligatorio.")
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function store_error_foreign_keys_does_not_exists()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/cost-center-expense-concept', self::$data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee("El campo cost center id seleccionado no existe.")
            ->assertSee("El campo expense concept id seleccionado no existe.")
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function store_ok()
    {
        self::$data['cost_center_id'] = 1;
        self::$data['expense_concept_id'] = 1;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/cost-center-expense-concept', self::$data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful store!')
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**     @test     */
    public function store_error_forbidden_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/cost-center-expense-concept', self::$data, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**     @test     */
    public function store_error_forbidden_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/cost-center-expense-concept', self::$data, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }
    /**     @test     */
    public function store_error_forbidden_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/cost-center-expense-concept', self::$data, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function show_ok()
    {
        self::$id = DB::table('cost_center_expense_concept')->latest()->first()->id;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/cost-center-expense-concept/' . self::$id, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get!')
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function show_fail_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/cost-center-expense-concept/' . self::$id, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function show_fail_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/cost-center-expense-concept/' . self::$id, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function show_fail_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/cost-center-expense-concept/' . self::$id, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function update_just_one_field_ok()
    {
        $updated_data = [
            'cost_center_id' => 4,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/cost-center-expense-concept/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(4)            //campo nuevo
            ->assertSee(1)                              //campo anterior
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function update_forbidden_for_tierra()
    {
        $updated_data = [
            'name' => 'new_name_test_updated',
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/cost-center-expense-concept/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
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
        $response = $this->put('/api/cost-center-expense-concept/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_AIRE')]);
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
        $response = $this->put('/api/cost-center-expense-concept/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function update_ok()
    {
        $updated_data = [
            'cost_center_id' => 2,
            'expense_concept_id' => 3,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/cost-center-expense-concept/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(2)
            ->assertSee(3)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function index_datatables_ok()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/cost-center-expense-concept?page=1', ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get')
            ->assertSee(2)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function index_datatables_error_forbidden_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/cost-center-expense-concept?page=1', ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function index_datatables_error_forbidden_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/cost-center-expense-concept?page=1', ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function index_datatables_error_forbidden_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/cost-center-expense-concept?page=1', ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete_forbidden_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/cost-center-expense-concept/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete_forbidden_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/cost-center-expense-concept/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete_forbidden_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/cost-center-expense-concept/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete_ok()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/cost-center-expense-concept/' . self::$id, [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful delete!')
            ->assertStatus(Response::HTTP_OK);
    }
}
