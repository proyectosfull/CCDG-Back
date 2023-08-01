<?php

namespace App\Http\Controllers;

use App\Custom\ErrorRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        logger('********************| ApiEmployeeController:index > start |********************');

        $data = Employee::index();

        logger('********************| ApiEmployeeController:index > end |********************');

        return response()->json([
            'status' => 1,
            'title' => 'Get all employees v23.7.3',
            'msg' => 'Successful get!',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        logger('********************| ApiEmployeeController:store > start |********************');

        $code = Response::HTTP_OK;
        $status = 0;
        $title = 'Store employee v23.7.3';
        $msg = 'Store failed!';
        $data = [];

        self::fieldsValidation($request, $title, true);

        $response = Employee::store($request);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful store!';
            $data = $response;
            $code = Response::HTTP_CREATED;
        }

        logger('********************| ApiEmployeeController:store > end |********************');

        return response()->json([
            'status' => $status,
            'title' => $title,
            'msg' => $msg,
            'data' => $data
        ], $code);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        logger('********************| ApiEmployeeController:show > start |********************');

        $data = $employee->showModel();

        logger('********************| ApiEmployeeController:show > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Get specific employee v23.7.3',
            'msg' => 'Successful get!',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        logger('********************| ApiEmployeeController:update > start |********************');

        $status = 0;
        $title = 'Update employee v23.7.3';
        $msg = 'Update failed!';
        $data = [];

        self::fieldsValidation($request, $title, false);

        $response = $employee->updateModel($request);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful update!';
            $data = $response;
        }

        logger('********************| ApiEmployeeController:update > end |********************');

        return response()->json([
            'status' => $status,
            'title' => $title,
            'msg' => $msg,
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        logger('********************| ApiEmployeeController:destroy > start |********************');

        $employee->delete();

        logger('********************| ApiEmployeeController:destroy > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Delete specific employee v23.7.3',
            'msg' => 'Successful delete!',
        ], Response::HTTP_OK);
    }

    /************************************************************************************************ VALIDATIONS */
    /**
     * Valida los campos recibidos en el request, optimizando el store y update
     * @param Request $request
     * @param string $title
     */
    private static function fieldsValidation(Request $request, string $title, bool $isStore)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => [($isStore ? 'required' : 'nullable'), 'string', 'max:150'],
            'email' => [($isStore ? 'required' : 'nullable'), 'string', 'max:100', Rule::unique('employees', 'email')->whereNull('deleted_at')],
            'phone_number' => ['nullable', 'string', 'max:255'],
        ]);

        ErrorRequest::getErrors($validator->errors(), $title);
    }
}
