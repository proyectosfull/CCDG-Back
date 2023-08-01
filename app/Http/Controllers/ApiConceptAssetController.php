<?php

namespace App\Http\Controllers;

use App\Custom\ErrorRequest;
use App\Models\ConceptAsset;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiConceptAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        logger('********************| ApiConceptAssetController:index > start |********************');

        $data = ConceptAsset::index();

        logger('********************| ApiConceptAssetController:index > end |********************');

        return response()->json([
            'status' => 1,
            'title' => 'Get all concept assets v23.7.3',
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
        logger('********************| ApiConceptAssetController:store > start |********************');

        $code = Response::HTTP_OK;
        $status = 0;
        $title = 'Store concept asset v23.7.3';
        $msg = 'Store failed!';
        $data = [];

        self::fieldsValidation($request, $title, true);

        $response = ConceptAsset::store($request);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful store!';
            $data = $response;
            $code = Response::HTTP_CREATED;
        }

        logger('********************| ApiConceptAssetController:store > end |********************');

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
     * @param  \App\Models\ConceptAsset  $conceptAsset
     * @return \Illuminate\Http\Response
     */
    public function show(ConceptAsset $conceptAsset)
    {
        logger('********************| ApiConceptAssetController:show > start |********************');

        $data = $conceptAsset->showModel();

        logger('********************| ApiConceptAssetController:show > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Get specific concept asset v23.7.3',
            'msg' => 'Successful get!',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ConceptAsset  $conceptAsset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConceptAsset $conceptAsset)
    {
        logger('********************| ApiConceptAssetController:update > start |********************');

        $status = 0;
        $title = 'Update concept asset v23.7.3';
        $msg = 'Update failed!';
        $data = [];

        self::fieldsValidation($request, $title, false);

        $response = $conceptAsset->updateModel($request);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful update!';
            $data = $response;
        }

        logger('********************| ApiConceptAssetController:update > end |********************');

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
     * @param  \App\Models\ConceptAsset  $conceptAsset
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConceptAsset $conceptAsset)
    {
        logger('********************| ApiConceptAssetController:destroy > start |********************');

        $conceptAsset->delete();

        logger('********************| ApiConceptAssetController:destroy > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Delete specific concept asset v23.7.3',
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
            'name' => [($isStore ? 'required' : 'nullable'), 'string', 'max:100', Rule::unique('concept_assets', 'name')->whereNull('deleted_at')],
        ]);

        ErrorRequest::getErrors($validator->errors(), $title);
    }
}
