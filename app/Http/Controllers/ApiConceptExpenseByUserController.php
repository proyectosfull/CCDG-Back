<?php

namespace App\Http\Controllers;

use App\Custom\ErrorRequest;
use App\Models\ConceptExpenseByUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiConceptExpenseByUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        logger('********************| ApiConceptExpenseByUserController:index > start |********************');

        $data = ConceptExpenseByUser::index();

        logger('********************| ApiConceptExpenseByUserController:index > end |********************');

        return response()->json([
            'status' => 1,
            'title' => 'Get all concept expense by users v23.7.3',
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
        logger('********************| ApiConceptExpenseByUserController:store > start |********************');

        $code = Response::HTTP_OK;
        $status = 0;
        $title = 'Store concept expense by user v23.7.3';
        $msg = 'Store failed!';
        $data = [];

        self::fieldsValidation($request, $title, true);

        $response = ConceptExpenseByUser::store($request);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful store!';
            $data = $response;
            $code = Response::HTTP_CREATED;
        }

        logger('********************| ApiConceptExpenseByUserController:store > end |********************');

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
     * @param  \App\Models\ConceptExpenseByUser  $conceptExpenseByUser
     * @return \Illuminate\Http\Response
     */
    public function show(ConceptExpenseByUser $conceptExpenseByUser)
    {
        logger('********************| ApiConceptExpenseByUserController:show > start |********************');

        $data = $conceptExpenseByUser->showModel();

        logger('********************| ApiConceptExpenseByUserController:show > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Get specific concept expense by user v23.7.3',
            'msg' => 'Successful get!',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ConceptExpenseByUser  $conceptExpenseByUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConceptExpenseByUser $conceptExpenseByUser)
    {
        logger('********************| ApiConceptExpenseByUserController:update > start |********************');

        $status = 0;
        $title = 'Update concept expense by user v23.7.3';
        $msg = 'Update failed!';
        $data = [];

        self::fieldsValidation($request, $title, false);

        $response = $conceptExpenseByUser->updateModel($request);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful update!';
            $data = $response;
        }

        logger('********************| ApiConceptExpenseByUserController:update > end |********************');

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
     * @param  \App\Models\ConceptExpenseByUser  $conceptExpenseByUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConceptExpenseByUser $conceptExpenseByUser)
    {
        logger('********************| ApiConceptExpenseByUserController:destroy > start |********************');

        $conceptExpenseByUser->delete();

        logger('********************| ApiConceptExpenseByUserController:destroy > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Delete specific concept expense by user v23.7.3',
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
            'expense_concept_id' => [($isStore ? 'required' : 'nullable'), 'integer', Rule::exists('expense_concepts', 'id')->whereNull('deleted_at')],
        ]);

        ErrorRequest::getErrors($validator->errors(), $title);
    }
}
