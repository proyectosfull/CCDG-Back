<?php

namespace App\Http\Controllers;

use App\Custom\ErrorRequest;
use App\Models\LandPayroll;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiLandPayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        logger('********************| ApiLandPayrollController:index > start |********************');
        
        $data = LandPayroll::index();
        
        logger('********************| ApiLandPayrollController:index > end |********************');

        return response()->json([
            'status' => 1,
            'title' => 'Get all land payrolls v23.7.3',
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
        logger('********************| ApiLandPayrollController:store > start |********************');

        $code = Response::HTTP_OK;
        $status = 0;
        $title = 'Store land payroll v23.7.3';
        $msg = 'Store failed!';
        $data = [];

        self::fieldsValidation($request, $title, true);

        $response = LandPayroll::store($request);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful store!';
            $data = $response;
            $code = Response::HTTP_CREATED;
        }

        logger('********************| ApiLandPayrollController:store > end |********************');
        
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
     * @param  \App\Models\LandPayroll  $landPayroll
     * @return \Illuminate\Http\Response
     */
    public function show(LandPayroll $landPayroll)
    {
        logger('********************| ApiLandPayrollController:show > start |********************');

        $data = $landPayroll->showModel();

        logger('********************| ApiLandPayrollController:show > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Get specific land payroll v23.7.3',
            'msg' => 'Successful get!',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LandPayroll  $landPayroll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LandPayroll $landPayroll)
    {
        logger('********************| ApiLandPayrollController:update > start |********************');

        $status = 0;
        $title = 'Update land payroll v23.7.3';
        $msg = 'Update failed!';
        $data = [];

        self::fieldsValidation($request, $title, false);

        $response = $landPayroll->updateModel($request);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful update!';
            $data = $response;
        }
       
        logger('********************| ApiLandPayrollController:update > end |********************');
       
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
     * @param  \App\Models\LandPayroll  $landPayroll
     * @return \Illuminate\Http\Response
     */
    public function destroy(LandPayroll $landPayroll)
    {
        logger('********************| ApiLandPayrollController:destroy > start |********************');
        
        $landPayroll->delete();
        
        logger('********************| ApiLandPayrollController:destroy > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Delete specific land payroll v23.7.3',
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
            'name' => [($isStore ? 'required' : 'nullable'), 'string', 'max:100', Rule::unique('land_payrolls','name')->whereNull('deleted_at')],
        ]);

        ErrorRequest::getErrors($validator->errors(), $title);
    }
}
