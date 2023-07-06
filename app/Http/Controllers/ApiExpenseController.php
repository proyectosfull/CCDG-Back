<?php

namespace App\Http\Controllers;

use App\Custom\ErrorRequest;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class ApiExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        logger('********************| ApiExpenseController:index > start |********************');
        
        $title = 'Get all expenses v23.7.2';

        self::fieldsValidation($request, $title, false);

        $data = Expense::indexModel($request);

        logger('********************| ApiExpenseController:index > end |********************');

        return response()->json([
            'status' => 1,
            'title' => $title,
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
        logger('********************| ApiExpenseController:store > start |********************');
        $code = Response::HTTP_OK;
        $status = 0;
        $title = 'Store expense v23.6.3';
        $msg = 'Store failed!';
        $data = [];

        self::fieldsValidation($request, $title, true);

        $response = Expense::store($request);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful store!';
            $data = $response;
            $code = Response::HTTP_CREATED;
        }

        logger('********************| ApiExpenseController:store > end |********************');

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
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        logger('********************| ApiExpenseController:show > start |********************');

        $data = $expense->showModel();

        logger('********************| ApiExpenseController:show > end |********************');

        return response()->json([
            'status' => 1,
            'title' => 'Get specific subcatalog v23.7.2',
            'msg' => 'Successful get!',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        logger('********************| ApiExpenseController:update > start |********************');

        $status = 0;
        $title = 'Update expense v23.7.2';
        $msg = 'Update failed!';
        $data = [];

        self::fieldsValidation($request, $title, false);

        $response = $expense->updateModel($request, $title);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful update!';
            $data = $response;
        }

        logger('********************| ApiExpenseController:update > end |********************');

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
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        logger('********************| ApiExpenseController:destroy > start |********************');

        $expense->delete();

        logger('********************| ApiExpenseController:destroy > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Delete specific expense v23.7.2',
            'msg' => 'Successful delete!',
        ], Response::HTTP_OK);
    }

    /************************************************************************************************ VALIDATIONS */
    /**
     * Valida los campos recibidos en el request, optimizando el store y update
     * @param Request $request
     * @param string $title
     * @return response json si existen errores
     */
    private static function fieldsValidation(Request $request, string $title, bool $isStore)
    {
        $validator = Validator::make($request->all(), [
            //required
            'user_id' => [($isStore ? 'required' : 'nullable'), 'integer', Rule::exists('users', 'id')->whereNull('deleted_at')],
            'cost_center_id' => [
                ($isStore ? 'required' : 'nullable'), 'integer', Rule::exists('catalogs', 'id')
                    ->whereNull('deleted_at'),
                Rule::in([1]) //catalogo: centro de costos
            ],
            'subcost_center_id' => [
                ($isStore ? 'required' : 'nullable'), 'integer', Rule::exists('subcatalogs', 'id')
                    ->whereNull('deleted_at'),
                Rule::in(range(1, 4)) //subcatalogos de centro de costos
            ],
            'subcatalog_id' => [
                ($isStore ? 'required' : 'nullable'), 'integer', Rule::exists('subcatalogs', 'id')
                    ->whereNull('deleted_at'),
                Rule::in(range(5, 45)) //los subcatalogos restantes
            ],
            'amount' => [($isStore ? 'required' : 'nullable'), 'regex:/^\d+(\.\d{1,2})?$/'],
            'date' => [($isStore ? 'required' : 'nullable'), 'date'],
            'observations' => ['nullable', 'string', 'max:255'],
            //for index
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);
        ErrorRequest::assertStartAndEndDate($request, $title);
        ErrorRequest::getErrors($validator->errors(), $title);
    }
}
