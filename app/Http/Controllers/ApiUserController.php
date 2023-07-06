<?php

namespace App\Http\Controllers;

use App\Custom\ErrorRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class ApiUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        logger('********************| ApiUserController:index > start |********************');

        $data = User::index();

        logger('********************| ApiUserController:index > end |********************');

        return response()->json([
            'status' => 1,
            'title' => 'Get all users v23.7.2',
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
        logger('********************| ApiUserController:store > start |********************');
        $code = Response::HTTP_OK;
        $status = 0;
        $title = 'Store user v23.6.3';
        $msg = 'Store failed!';
        $data = [];

        self::fieldsValidation($request, $title, true);

        $response = User::store($request);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful store!';
            $data = $response;
            $code = Response::HTTP_CREATED;
        }

        logger('********************| ApiUserController:store > end |********************');
        
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        logger('********************| ApiUserController:show > start |********************');

        $data = $user->showModel();

        logger('********************| ApiUserController:show > end |********************');

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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        logger('********************| ApiUserController:update > start |********************');

        $status = 0;
        $title = 'Update user v23.7.2';
        $msg = 'Update failed!';
        $data = [];

        self::fieldsValidation($request, $title, false);

        $response = $user->updateModel($request, $title);

        if (!empty($response)) {
            $status = 1;
            $msg = 'Successful update!';
            $data = $response;
        }

        logger('********************| ApiUserController:update > end |********************');

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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        logger('********************| ApiUserController:destroy > start |********************');

        $user->delete();

        logger('********************| ApiUserController:destroy > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Delete specific user v23.7.2',
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
            'email' => [($isStore ? 'required' : 'nullable'), 'string', 'max:255', Rule::unique('users')->whereNull('deleted_at')],
            'name' => [($isStore ? 'required' : 'nullable'), 'string', 'max:255'],
            'password' => [($isStore ? 'required' : 'nullable'), 'string', 'max:255'],
            // 'role' => [($isStore ? 'required' : 'nullable'), 'string', Rule::in(['administrador', 'operador'])],
            'role' => [($isStore ? 'required' : 'nullable'), 'string', Rule::exists('roles','name')],
        ]);

        ErrorRequest::getErrors($validator->errors(), $title);
    }
}
