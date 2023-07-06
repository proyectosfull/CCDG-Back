<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ApiExpenseControllerTest extends TestCase
{
    // 1. Given => teniendo, el estado antes de la accion que queremos realizar
    //Data
    protected static $id = 1;
    protected static $data = [
        'user_id' => 20,
        'cost_center_id' => 10,
        'subcost_center_id' => 30,
        'subcatalog_id' => 50,
        'amount' => 999.99,
        'observations' => 'observations_test',
        'date' => '2023-07-05',
    ];

    /**
     * Error. @test
     */
    public function store_error_data_empty()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/expense', [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee("El campo user id es obligatorio.")
            ->assertSee("El campo cost center id es obligatorio.")
            ->assertSee("El campo subcost center id es obligatorio.")
            ->assertSee("El campo subcatalog id es obligatorio.")
            ->assertSee("El campo amount es obligatorio.")
            ->assertSee("El campo date es obligatorio.")
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Error. @test
     */
    public function store_error_foreign_does_not_exists()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/expense', self::$data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee("El campo user id seleccionado no existe.")
            ->assertSee("El campo cost center id seleccionado no existe.")
            ->assertSee("El campo cost center id es inv")
            ->assertSee("El campo subcost center id es inv")
            ->assertSee("El campo subcatalog id seleccionado no existe.")
            ->assertSee("El campo subcatalog id es inv")
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Creacion normal. @test
     */
    public function store_ok()
    {
        self::$data['user_id'] = 2;
        self::$data['cost_center_id'] = 1;
        self::$data['subcost_center_id'] = 3;
        self::$data['subcatalog_id'] = 5;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/expense', self::$data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful store!')
            ->assertSee(999.99)
            ->assertSee('2023-07-05')
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * Show normal. @test
     */
    public function show_ok()
    {
        self::$id = DB::table('expenses')->latest()->first()->id;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/expense/' . self::$id, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get!')
            ->assertSee('2023-07-05')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Update normal. @test
     */
    public function update_just_one_field_ok()
    {
        $updated_data = [
            'amount' => 999.69,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/expense/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(999.69)                     //campo nuevo
            ->assertSee('2023-07-05')              //campo anterior
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Update normal. @test
     */
    public function update_ok()
    {
        $updated_data = [
            'user_id' => 1,
            'cost_center_id' => 1,
            'subcost_center_id' => 4,
            'subcatalog_id' => 6,
            'amount' => 999.01,
            'observations' => 'observations_test_up',
            'date' => '2023-07-06',
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/expense/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(1)
            ->assertSee(1)
            ->assertSee(4)
            ->assertSee(6)
            ->assertSee(999.01)
            ->assertSee('observations_test_up')
            ->assertSee('2023-07-06')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Datatables normal. @test
     */
    public function index_datatables_ok()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/expense', ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('observations_test_up')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Datatables normal. @test
     */
    public function index_datatables_ok_with_filters()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/expense?user_id=1&subcost_center_id=4&subcatalog_id=6&start_date=2023-01-01&end_date=2023-12-31', ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('observations_test_up')
            ->assertStatus(Response::HTTP_OK);
    }

    /**
     * delete normal. @test
     */
    public function delete_ok()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/expense/' . self::$id, [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful delete!')
            ->assertStatus(Response::HTTP_OK);
    }
}
