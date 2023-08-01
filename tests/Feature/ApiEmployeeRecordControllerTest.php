<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ApiEmployeeRecordControllerTest extends TestCase
{
    // 1. Given => teniendo, el estado antes de la accion que queremos realizar
    //Data
    protected static $id = 1;
    protected static $data = [
        'full_name' => 'full_name_test',
        'monthly_salary' => 10000.99,
        'area_id' => 10,
        'subcost_center_id' => 100,
    ];

    /**     @test     */
    public function store_error_data_empty()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/employee-record', [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee("El campo full name es obligatorio.")
            ->assertSee("El campo monthly salary es obligatorio.")
            ->assertSee("El campo area id es obligatorio.")
            ->assertSee("El campo subcost center id es obligatorio.")
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function store_error_foreign_keys_does_not_exists()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/employee-record', self::$data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee("El campo area id seleccionado no existe.")
            ->assertSee("El campo subcost center id seleccionado no existe.")
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function store_ok_for_tierra()
    {
        self::$data['area_id'] = 1;
        self::$data['subcost_center_id'] = 1;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/employee-record', self::$data, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful store!')
            ->assertSee('full_name_test')
            ->assertSee(10000.99)
            ->assertSee(1)
            ->assertSee(1)
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**     @test     */
    public function show_ok_for_tierra()
    {
        sleep(1);
        self::$id = DB::table('employee_records')->latest()->first()->id;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/employee-record/' . self::$id, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
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
            'monthly_salary' => 10000.99,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/employee-record/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(10000.99)                      //campo nuevo
            ->assertSee('full_name_test')                     //campo anterior
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function update_ok_for_tierra()
    {
        $updated_data = [
            'monthly_salary' => 10000.01,
            'full_name' => 'full_name_updated',
            'area_id' => 2,
            'subcost_center_id' => 2,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/employee-record/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee('full_name_updated')
            ->assertSee(10000.01)
            ->assertSee(2)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function index_datatables_ok_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/employee-record?page=1', ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get')
            ->assertSee(10000.01)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function delete_forbidden_for_tierra()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/employee-record/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_TIERRA')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete_ok_for_admin()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/employee-record/' . self::$id, [], ['Authorization' => env('TOKEN_TEST')]);
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
        self::$data['area_id'] = 1;
        self::$data['subcost_center_id'] = 1;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/employee-record', self::$data, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful store!')
            ->assertSee('full_name_test')
            ->assertSee(10000.99)
            ->assertSee(1)
            ->assertSee(1)
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**     @test     */
    public function show_ok_for_aire()
    {
        sleep(1);
        self::$id = DB::table('employee_records')->latest()->first()->id;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/employee-record/' . self::$id, ['Authorization' => env('TOKEN_TEST_AIRE')]);
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
            'monthly_salary' => 10000.99,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/employee-record/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(10000.99)                      //campo nuevo
            ->assertSee('full_name_test')                     //campo anterior
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function update_ok_for_aire()
    {
        $updated_data = [
            'monthly_salary' => 10000.01,
            'full_name' => 'full_name_updated',
            'area_id' => 2,
            'subcost_center_id' => 2,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/employee-record/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee('full_name_updated')
            ->assertSee(10000.01)
            ->assertSee(2)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function index_datatables_ok_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/employee-record?page=1', ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get')
            ->assertSee(10000.01)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function delete_forbidden_for_aire()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/employee-record/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_AIRE')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete2_ok_for_admin()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/employee-record/' . self::$id, [], ['Authorization' => env('TOKEN_TEST')]);
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
        self::$data['area_id'] = 1;
        self::$data['subcost_center_id'] = 1;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/employee-record', self::$data, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful store!')
            ->assertSee('full_name_test')
            ->assertSee(10000.99)
            ->assertSee(1)
            ->assertSee(1)
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**     @test     */
    public function show_ok_for_milagros()
    {
        sleep(1);
        self::$id = DB::table('employee_records')->latest()->first()->id;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/employee-record/' . self::$id, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
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
            'monthly_salary' => 10000.99,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/employee-record/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(10000.99)                      //campo nuevo
            ->assertSee('full_name_test')                     //campo anterior
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function update_ok_for_milagros()
    {
        $updated_data = [
            'monthly_salary' => 10000.01,
            'full_name' => 'full_name_updated',
            'area_id' => 2,
            'subcost_center_id' => 2,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/employee-record/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee('full_name_updated')
            ->assertSee(10000.01)
            ->assertSee(2)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function index_datatables_ok_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/employee-record?page=1', ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get')
            ->assertSee(10000.01)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function delete_forbidden_for_milagros()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/employee-record/' . self::$id, [], ['Authorization' => env('TOKEN_TEST_MILAGROS')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**     @test     */
    public function delete3_ok_for_admin()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/employee-record/' . self::$id, [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful delete!')
            ->assertStatus(Response::HTTP_OK);
    }

    // /**
    //  * 
    //  * ADMIN
    //  * 
    //  */

    /**     @test     */
    public function store_ok_for_admin()
    {
        self::$data['area_id'] = 1;
        self::$data['subcost_center_id'] = 1;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->post('/api/employee-record', self::$data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful store!')
            ->assertSee('full_name_test')
            ->assertSee(10000.99)
            ->assertSee(1)
            ->assertSee(1)
            ->assertStatus(Response::HTTP_CREATED);
    }

    /**     @test     */
    public function show_ok_for_admin()
    {
        sleep(1);
        self::$id = DB::table('employee_records')->latest()->first()->id;
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/employee-record/' . self::$id, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get!')
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function update_just_one_field_ok_for_admin()
    {
        $updated_data = [
            'monthly_salary' => 10000.99,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/employee-record/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee(10000.99)                      //campo nuevo
            ->assertSee('full_name_test')                     //campo anterior
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function update_ok_for_admin()
    {
        $updated_data = [
            'monthly_salary' => 10000.01,
            'full_name' => 'full_name_updated',
            'area_id' => 2,
            'subcost_center_id' => 2,
        ];
        //2. When => Cuando, realizamos dicha accion
        $response = $this->put('/api/employee-record/' . self::$id, $updated_data, ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful update!')
            ->assertSee('full_name_updated')
            ->assertSee(10000.01)
            ->assertSee(2)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function index_datatables_ok_for_admin()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->get('/api/employee-record?page=1', ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful get')
            ->assertSee(10000.01)
            ->assertStatus(Response::HTTP_OK);
    }

    /**     @test     */
    public function delete4_ok_for_admin()
    {
        //2. When => Cuando, realizamos dicha accion
        $response = $this->delete('/api/employee-record/' . self::$id, [], ['Authorization' => env('TOKEN_TEST')]);
        //3. Then => Entonces, comprobamos los resultados obtenidos y que son los esperados
        $response
            ->assertSee('Successful delete!')
            ->assertStatus(Response::HTTP_OK);
    }
}
