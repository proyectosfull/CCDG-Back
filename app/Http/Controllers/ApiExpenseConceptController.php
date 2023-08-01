<?php

namespace App\Http\Controllers;

use App\Custom\ErrorRequest;
use App\Models\ExpenseConcept;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiExpenseConceptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        logger('********************| ApiExpenseConceptController:index > start |********************');

        $data = ExpenseConcept::index();

        logger('********************| ApiExpenseConceptController:index > end |********************');

        return response()->json([
            'status' => 1,
            'title' => 'Get all expense concepts v23.7.3',
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
        logger('********************| ApiExpenseConceptController:store > start |********************');

        $code = Response::HTTP_OK;
        $status = 0;
        $title = 'Store expense concept v23.7.3';
        $msg = 'Store failed!';
        $data = [];

        self::fieldsValidation($request, $title, true);

        $response = ExpenseConcept::store($request);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful store!';
            $data = $response;
            $code = Response::HTTP_CREATED;
        }

        logger('********************| ApiExpenseConceptController:store > end |********************');

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
     * @param  \App\Models\ExpenseConcept  $expenseConcept
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseConcept $expenseConcept)
    {
        logger('********************| ApiExpenseConceptController:show > start |********************');

        $data = $expenseConcept->showModel();

        logger('********************| ApiExpenseConceptController:show > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Get specific expense concept v23.7.3',
            'msg' => 'Successful get!',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExpenseConcept  $expenseConcept
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExpenseConcept $expenseConcept)
    {
        logger('********************| ApiExpenseConceptController:update > start |********************');

        $status = 0;
        $title = 'Update expense concept v23.7.3';
        $msg = 'Update failed!';
        $data = [];

        self::fieldsValidation($request, $title, false);

        $response = $expenseConcept->updateModel($request);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful update!';
            $data = $response;
        }

        logger('********************| ApiExpenseConceptController:update > end |********************');

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
     * @param  \App\Models\ExpenseConcept  $expenseConcept
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExpenseConcept $expenseConcept)
    {
        logger('********************| ApiExpenseConceptController:destroy > start |********************');

        $expenseConcept->delete();

        logger('********************| ApiExpenseConceptController:destroy > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Delete specific expense concept v23.7.3',
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
            'name' => [($isStore ? 'required' : 'nullable'), 'string', 'max:100', Rule::unique('expense_concepts','name')->whereNull('deleted_at')],
        ]);

        ErrorRequest::getErrors($validator->errors(), $title);
    }
}
