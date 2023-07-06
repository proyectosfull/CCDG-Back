<?php

namespace App\Http\Controllers;

use App\Custom\ErrorRequest;
use App\Models\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class ApiCatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        logger('********************| ApiCatalogController:index > start |********************');
        
        $data = Catalog::index();
        
        logger('********************| ApiCatalogController:index > end |********************');

        return response()->json([
            'status' => 1,
            'title' => 'Get all catalogs v23.7.2',
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
        logger('********************| ApiCatalogController:store > start |********************');

        $code = Response::HTTP_OK;
        $status = 0;
        $title = 'Store catalog v23.7.2';
        $msg = 'Store failed!';
        $data = [];

        self::fieldsValidation($request, $title, true);

        $response = Catalog::store($request, $title);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful store!';
            $data = $response;
            $code = Response::HTTP_CREATED;
        }

        logger('********************| ApiCatalogController:store > end |********************');
        
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
     * @param  \App\Models\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function show(Catalog $catalog)
    {
        logger('********************| ApiCatalogController:show > start |********************');

        $data = $catalog->showModel();

        logger('********************| ApiCatalogController:show > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Get specific catalog v23.7.2',
            'msg' => 'Successful get!',
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catalog $catalog)
    {
        logger('********************| ApiCatalogController:update > start |********************');

        $status = 0;
        $title = 'Update catalog v23.7.2';
        $msg = 'Update failed!';
        $data = [];

        self::fieldsValidation($request, $title, false);

        $response = $catalog->updateModel($request, $title);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful update!';
            $data = $response;
        }
       
        logger('********************| ApiCatalogController:update > end |********************');
       
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
     * @param  \App\Models\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catalog $catalog)
    {
        logger('********************| ApiCatalogController:destroy > start |********************');
        
        $catalog->delete();
        
        logger('********************| ApiCatalogController:destroy > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Delete specific catalog v23.7.2',
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
        //TO DO hacer el validation con los campos

        $validator = Validator::make($request->all(), [
            'name' => [($isStore ? 'required' : 'nullable'), 'string', 'max:100', Rule::unique('catalogs','name')->whereNull('deleted_at')],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        ErrorRequest::getErrors($validator->errors(), $title);
    }
}
