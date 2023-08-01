<?php

namespace App\Http\Controllers;

use App\Custom\ErrorRequest;
use App\Models\CostCenterExpenseConcept;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiCostCenterExpenseConceptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        logger('********************| ApiCostCenterExpenseConceptController:index > start |********************');

        $data = CostCenterExpenseConcept::index();

        logger('********************| ApiCostCenterExpenseConceptController:index > end |********************');

        return response()->json([
            'status' => 1,
            'title' => 'Get all cost center expense concepts v23.7.3',
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
        logger('********************| ApiCostCenterExpenseConceptController:store > start |********************');

        $code = Response::HTTP_OK;
        $status = 0;
        $title = 'Store cost center expense concept v23.7.3';
        $msg = 'Store failed!';
        $data = [];

        self::fieldsValidation($request, $title, true);

        $response = CostCenterExpenseConcept::store($request);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful store!';
            $data = $response;
            $code = Response::HTTP_CREATED;
        }

        logger('********************| ApiCostCenterExpenseConceptController:store > end |********************');

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
     * @param  \App\Models\CostCenterExpenseConcept  $costCenterExpenseConcept
     * @return \Illuminate\Http\Response
     */
    public function show(CostCenterExpenseConcept $costCenterExpenseConcept)
    {
        logger('********************| ApiCostCenterExpenseConceptController:show > start |********************');

        $data = $costCenterExpenseConcept->showModel();

        logger('********************| ApiCostCenterExpenseConceptController:show > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Get specific cost center expense concept v23.7.3',
            'msg' => 'Successful get!',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CostCenterExpenseConcept  $costCenterExpenseConcept
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CostCenterExpenseConcept $costCenterExpenseConcept)
    {
        logger('********************| ApiCostCenterExpenseConceptController:update > start |********************');

        $status = 0;
        $title = 'Update cost center expense concept v23.7.3';
        $msg = 'Update failed!';
        $data = [];

        self::fieldsValidation($request, $title, false);

        $response = $costCenterExpenseConcept->updateModel($request);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful update!';
            $data = $response;
        }

        logger('********************| ApiCostCenterExpenseConceptController:update > end |********************');

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
     * @param  \App\Models\CostCenterExpenseConcept  $costCenterExpenseConcept
     * @return \Illuminate\Http\Response
     */
    public function destroy(CostCenterExpenseConcept $costCenterExpenseConcept)
    {
        logger('********************| ApiCostCenterExpenseConceptController:destroy > start |********************');

        $costCenterExpenseConcept->delete();

        logger('********************| ApiCostCenterExpenseConceptController:destroy > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Delete specific cost center expense concept v23.7.3',
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
            'cost_center_id' => [($isStore ? 'required' : 'nullable'), 'integer', Rule::exists('cost_centers', 'id')->whereNull('deleted_at')],
            'expense_concept_id' => [($isStore ? 'required' : 'nullable'), 'integer', Rule::exists('expense_concepts', 'id')->whereNull('deleted_at')],
        ]);

        ErrorRequest::getErrors($validator->errors(), $title);
    }
}
