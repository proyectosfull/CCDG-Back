<?php

namespace App\Http\Controllers;

use App\Custom\ErrorRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        logger('********************| AuthController:login > start |********************');
        $status = 0;
        $title = 'Login v23.7.1';
        $msg = 'No autorizado, email/contraseña incorrectos';
        $code = Response::HTTP_UNAUTHORIZED;
        $token = '';
        $role = '';
        // $cookie = '';

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = request(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('AccessTokenMC')->plainTextToken;
            // $cookie = cookie('cookie_token', $token, 60 * 24);
            $status = 1;
            $msg = 'Credenciales correctas.';
            $code = Response::HTTP_OK;
            //solamente manejamos un role por usuario, y el método nos regresa un arreglo, si no existe ese dato, retorna false
            try {
                //solamente manejamos un role por usuario, si no ese dato, hubo una asignacion erronea.
                $role = $user->getRoleNames()[0];
            } catch (Exception $e) {
                $role = $e;
            }
        }

        logger('********************| AuthController:login > end |********************');

        return response()->json([
            'status' => $status,
            'title' => $title,
            'message' => $msg,
            'bearer_token' => $token,
            'role' => $role,
        ], $code);
        /** por si se quiere enviar en cookie */
        // ->withCookie($cookie);
    }

    public function logout(Request $request)
    {
        logger('********************| AuthController:logout > start |********************');

        $request->user()->currentAccessToken()->delete();

        logger('********************| AuthController:logout > end |********************');
        return response()->json([
            'status' => 1,
            'title' => 'Cerrar sesión v23.7.1',
            'msg' => 'Se cerró sesión correctamente.',
        ], Response::HTTP_OK);
    }

    public static function getRoleName(Request $request, string $title)
    {
        logger('********************| AuthController:getRoleName > start |********************');

        $roleName = $request->user()->getRoleNames()[0] ?? null;

        if (is_null($roleName)) {
            ErrorRequest::genericErrors(['ERROR: El usuario no tiene un rol asignado.'], $title);
        }
        logger('********************| AuthController:getRoleName > end |********************');
        return $roleName;
    }
}
