<?php

namespace App\Http\Controllers;

use App\Custom\ErrorRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiTransactionController extends Controller
{
    protected static $TRANSACTION_TYPES = ['Efectivo', 'Activo'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        logger('********************| ApiTransactionController:index > start |********************');

        $data = Transaction::index();

        logger('********************| ApiTransactionController:index > end |********************');

        return response()->json([
            'status' => 1,
            'title' => 'Get all transactions v23.7.3',
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
        logger('********************| ApiTransactionController:store > start |********************');

        $code = Response::HTTP_OK;
        $status = 0;
        $title = 'Store transaction v23.7.4';
        $msg = 'Store failed!';
        $data = [];

        self::fieldsValidation($request, $title, true);

        $response = Transaction::store($request, $title);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful store!';
            $data = $response;
            $code = Response::HTTP_CREATED;
        }

        logger('********************| ApiTransactionController:store > end |********************');

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
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        logger('********************| ApiTransactionController:show > start |********************');

        $data = $transaction->showModel();

        logger('********************| ApiTransactionController:show > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Get specific transaction v23.7.3',
            'msg' => 'Successful get!',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        logger('********************| ApiTransactionController:update > start |********************');

        $status = 0;
        $title = 'Update transaction v23.7.4';
        $msg = 'Update failed!';
        $data = [];

        self::fieldsValidation($request, $title, false);

        $response = $transaction->updateModel($request, $title);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful update!';
            $data = $response;
        }

        logger('********************| ApiTransactionController:update > end |********************');

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
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        logger('********************| ApiTransactionController:destroy > start |********************');

        $title = 'Delete specific transaction v23.7.4';
        $transaction->deleteModel($title);

        logger('********************| ApiTransactionController:destroy > end |********************');
        return response()->json([
            'status' => 1,
            'title' => $title,
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
            'user_id' => [($isStore ? 'required' : 'nullable'), 'integer', Rule::exists('users', 'id')->whereNull('deleted_at')],
            'origin_cost_center_id' => [($isStore ? 'required' : 'nullable'), 'integer', Rule::exists('cost_centers', 'id')->whereNull('deleted_at')],
            'destiny_cost_center_id' => [($isStore ? 'required' : 'nullable'), 'integer', Rule::exists('cost_centers', 'id')->whereNull('deleted_at')],
            'employee_id' => [($isStore ? 'required' : 'nullable'), 'integer', Rule::exists('employees', 'id')->whereNull('deleted_at')],
            'expense_concept_id' => [($isStore ? 'required' : 'nullable'), 'integer', Rule::exists('expense_concepts', 'id')->whereNull('deleted_at')],
            'transaction_type' => [($isStore ? 'required' : 'nullable'), 'string', Rule::in(self::$TRANSACTION_TYPES)],
            'amount' => [($isStore ? 'required' : 'nullable'), 'regex:/^\d+(\.\d{1,2})?$/'],
            'date_time' => [($isStore ? 'required' : 'nullable'), 'date'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        ErrorRequest::getErrors($validator->errors(), $title);
    }
}
