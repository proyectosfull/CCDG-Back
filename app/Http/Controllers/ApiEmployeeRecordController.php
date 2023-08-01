<?php

namespace App\Http\Controllers;

use App\Custom\ErrorRequest;
use App\Models\EmployeeRecord;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiEmployeeRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        logger('********************| ApiEmployeeRecordController:index > start |********************');

        $data = EmployeeRecord::index();

        logger('********************| ApiEmployeeRecordController:index > end |********************');

        return response()->json([
            'status' => 1,
            'title' => 'Get all employee records v23.7.3',
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
        logger('********************| ApiEmployeeRecordController:store > start |********************');

        $code = Response::HTTP_OK;
        $status = 0;
        $title = 'Store employee record v23.7.3';
        $msg = 'Store failed!';
        $data = [];

        self::fieldsValidation($request, $title, true);

        $response = EmployeeRecord::store($request);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful store!';
            $data = $response;
            $code = Response::HTTP_CREATED;
        }

        logger('********************| ApiEmployeeRecordController:store > end |********************');

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
     * @param  \App\Models\EmployeeRecord  $employeeRecord
     * @return \Illuminate\Http\Response
     */
    public function show(EmployeeRecord $employeeRecord)
    {
        logger('********************| ApiEmployeeRecordController:show > start |********************');

        $data = $employeeRecord->showModel();

        logger('********************| ApiEmployeeRecordController:show > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Get specific employee record v23.7.3',
            'msg' => 'Successful get!',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmployeeRecord  $employeeRecord
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeRecord $employeeRecord)
    {
        logger('********************| ApiEmployeeRecordController:update > start |********************');

        $status = 0;
        $title = 'Update employee record v23.7.3';
        $msg = 'Update failed!';
        $data = [];

        self::fieldsValidation($request, $title, false);

        $response = $employeeRecord->updateModel($request);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful update!';
            $data = $response;
        }

        logger('********************| ApiEmployeeRecordController:update > end |********************');

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
     * @param  \App\Models\EmployeeRecord  $employeeRecord
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmployeeRecord $employeeRecord)
    {
        logger('********************| ApiEmployeeRecordController:destroy > start |********************');

        $employeeRecord->delete();

        logger('********************| ApiEmployeeRecordController:destroy > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Delete specific employee record v23.7.3',
            'msg' => 'Successful delete!',
        ], Response::HTTP_OK);
    }

    /************************************************************************************************ VALIDATIONS */
    /**
     * Valida los campos recibidos en el request, optimizando el store y update
     * @param Request $request
     * @param string $title
     * @return response json si existen errores, en caso contrario retorna null.
     */
    private static function fieldsValidation(Request $request, string $title, bool $isStore)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => [($isStore ? 'required' : 'nullable'), 'string', 'max:150', Rule::unique('employee_records', 'full_name')->whereNull('deleted_at')],
            'monthly_salary' => [($isStore ? 'required' : 'nullable'), 'regex:/^\d+(\.\d{1,2})?$/'],
            'area_id' => [($isStore ? 'required' : 'nullable'), 'integer', Rule::exists('areas', 'id')->whereNull('deleted_at')],
            'subcost_center_id' => [($isStore ? 'required' : 'nullable'), 'integer', Rule::exists('subcost_centers', 'id')->whereNull('deleted_at')],
        ]);

        ErrorRequest::getErrors($validator->errors(), $title);
    }
}
