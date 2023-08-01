<?php

namespace App\Http\Controllers;

use App\Custom\ErrorRequest;
use App\Models\SubcostCenter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiSubcostCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        logger('********************| ApiSubcostCenterController:index > start |********************');

        $data = SubcostCenter::index();

        logger('********************| ApiSubcostCenterController:index > end |********************');

        return response()->json([
            'status' => 1,
            'title' => 'Get all subcost centers v23.7.3',
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
        logger('********************| ApiSubcostCenterController:store > start |********************');

        $code = Response::HTTP_OK;
        $status = 0;
        $title = 'Store subcost center v23.7.3';
        $msg = 'Store failed!';
        $data = [];

        self::fieldsValidation($request, $title, true);

        $response = SubcostCenter::store($request, $title);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful store!';
            $data = $response;
            $code = Response::HTTP_CREATED;
        }

        logger('********************| ApiSubcostCenterController:store > end |********************');

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
     * @param  \App\Models\SubcostCenter  $subcostCenter
     * @return \Illuminate\Http\Response
     */
    public function show(SubcostCenter $subcostCenter)
    {
        logger('********************| ApiSubcostCenterController:show > start |********************');

        $data = $subcostCenter->showModel();

        logger('********************| ApiSubcostCenterController:show > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Get specific subcost center v23.7.3',
            'msg' => 'Successful get!',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubcostCenter  $subcostCenter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubcostCenter $subcostCenter)
    {
        logger('********************| ApiSubcostCenterController:update > start |********************');

        $status = 0;
        $title = 'Update subcost center v23.7.3';
        $msg = 'Update failed!';
        $data = [];

        self::fieldsValidation($request, $title, false);

        $response = $subcostCenter->updateModel($request);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful update!';
            $data = $response;
        }

        logger('********************| ApiSubcostCenterController:update > end |********************');

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
     * @param  \App\Models\SubcostCenter  $subcostCenter
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubcostCenter $subcostCenter)
    {
        logger('********************| ApiSubcostCenterController:destroy > start |********************');

        $subcostCenter->delete();

        logger('********************| ApiSubcostCenterController:destroy > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Delete specific subcost center v23.7.3',
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
            'name' => [($isStore ? 'required' : 'nullable'), 'string', 'max:100', Rule::unique('subcost_centers', 'name')->whereNull('deleted_at')],
        ]);

        ErrorRequest::getErrors($validator->errors(), $title);
    }
}
