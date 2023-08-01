<?php

namespace App\Http\Controllers;

use App\Custom\ErrorRequest;
use App\Models\AccountStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiAccountStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        logger('********************| ApiAccountStatusController:index > start |********************');

        $title = 'Get all account statuses v23.7.3';
        $data = AccountStatus::index($request, $title);

        logger('********************| ApiAccountStatusController:index > end |********************');

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
        logger('********************| ApiAccountStatusController:store > start |********************');

        $code = Response::HTTP_OK;
        $status = 0;
        $title = 'Store account status v23.7.3';
        $msg = 'Store failed!';
        $data = [];

        self::fieldsValidation($request, $title, true);

        $response = AccountStatus::store($request, $title);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful store!';
            $data = $response;
            $code = Response::HTTP_CREATED;
        }

        logger('********************| ApiAccountStatusController:store > end |********************');

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
     * @param  \App\Models\AccountStatus  $accountStatus
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, AccountStatus $accountStatus)
    {
        logger('********************| ApiAccountStatusController:show > start |********************');

        $title = 'Get specific account status v23.7.3';
        $data = $accountStatus->showModel($request, $title);

        logger('********************| ApiAccountStatusController:show > end |********************');
        return response()->json([
            'status' => 1,
            'title' => $title,
            'msg' => 'Successful get!',
            'data' => $data ?? [],
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountStatus  $accountStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountStatus $accountStatus)
    {
        logger('********************| ApiAccountStatusController:update > start |********************');

        $status = 0;
        $title = 'Update account status v23.7.3';
        $msg = 'Update failed!';
        $data = [];

        self::fieldsValidation($request, $title, false);

        $response = $accountStatus->updateModel($request, $title);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful update!';
            $data = $response;
        }

        logger('********************| ApiAccountStatusController:update > end |********************');

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
     * @param  \App\Models\AccountStatus  $accountStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountStatus $accountStatus)
    {
        logger('********************| ApiAccountStatusController:destroy > start |********************');

        $accountStatus->delete();

        logger('********************| ApiAccountStatusController:destroy > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Delete specific account status v23.7.3',
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
            'cost_center_id' => [($isStore ? 'required' : 'nullable'), 'integer', Rule::exists('cost_centers', 'id')->whereNull('deleted_at')],
            'current_stock' => [($isStore ? 'required' : 'nullable'), 'integer'],
            'concept_asset_id' => [($isStore ? 'required' : 'nullable'), 'integer', Rule::exists('concept_assets', 'id')->whereNull('deleted_at')],
        ]);

        ErrorRequest::getErrors($validator->errors(), $title);
    }
}
