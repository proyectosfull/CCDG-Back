<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpFoundation\Response;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        logger('********************| Middleware/Authenticate:redirectTo > start |********************');
        if (!$request->expectsJson()) {
            logger('********************| Middleware/Authenticate:redirectTo > end |********************');
            abort(response()->json([
                'status' => 0,
                'title' => 'HTTP_UNAUTHORIZED',
                'msg' => 'No has iniciado sesión o tu token ha caducado, intenta ingresando nuevamente.',
            ], Response::HTTP_UNAUTHORIZED));
        }
    }
}
