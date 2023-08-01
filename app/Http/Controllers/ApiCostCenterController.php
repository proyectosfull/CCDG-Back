<?php

namespace App\Http\Controllers;

use App\Custom\ErrorRequest;
use App\Models\CostCenter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiCostCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        logger('********************| ApiCostCenterController:index > start |********************');

        $data = CostCenter::index();

        logger('********************| ApiCostCenterController:index > end |********************');

        return response()->json([
            'status' => 1,
            'title' => 'Get all cost centers v23.7.3',
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
        logger('********************| ApiCostCenterController:store > start |********************');

        $code = Response::HTTP_OK;
        $status = 0;
        $title = 'Store cost center v23.7.3';
        $msg = 'Store failed!';
        $data = [];

        self::fieldsValidation($request, $title, true);

        $response = CostCenter::store($request);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful store!';
            $data = $response;
            $code = Response::HTTP_CREATED;
        }

        logger('********************| ApiCostCenterController:store > end |********************');

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
     * @param  \App\Models\CostCenter  $costCenter
     * @return \Illuminate\Http\Response
     */
    public function show(CostCenter $costCenter)
    {
        logger('********************| ApiCostCenterController:show > start |********************');

        $data = $costCenter->showModel();

        logger('********************| ApiCostCenterController:show > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Get specific cost center v23.7.3',
            'msg' => 'Successful get!',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CostCenter  $costCenter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CostCenter $costCenter)
    {
        logger('********************| ApiCostCenterController:update > start |********************');

        $status = 0;
        $title = 'Update cost center v23.7.3';
        $msg = 'Update failed!';
        $data = [];

        self::fieldsValidation($request, $title, false);

        $response = $costCenter->updateModel($request);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful update!';
            $data = $response;
        }

        logger('********************| ApiCostCenterController:update > end |********************');

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
     * @param  \App\Models\CostCenter  $costCenter
     * @return \Illuminate\Http\Response
     */
    public function destroy(CostCenter $costCenter)
    {
        logger('********************| ApiCostCenterController:destroy > start |********************');

        $costCenter->delete();

        logger('********************| ApiCostCenterController:destroy > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Delete specific cost center v23.7.3',
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
            'name' => [($isStore ? 'required' : 'nullable'), 'string', 'max:100', Rule::unique('cost_centers', 'name')->whereNull('deleted_at')],
            'budget' => ['nullable', 'regex:/^\d+(\.\d{1,2})?$/'],
        ]);

        ErrorRequest::getErrors($validator->errors(), $title);
    }
}
