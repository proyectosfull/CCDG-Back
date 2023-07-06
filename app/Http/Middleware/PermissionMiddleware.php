<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        logger('********************| Middleware/PermissionMiddleware:handle > start |********************');
        // if (Auth::guest()) {
        //     return redirect('/login');
        // }
        $route = $request->route()?->getName();
        if (!$request->user()->can($route)) {
            abort(response()->json([
                'status' => 0,
                'title' => 'HTTP_FORBIDDEN',
                'msg' => 'No tienes permisos para realizar la petición: ' . $route,
            ], Response::HTTP_FORBIDDEN));
        }
        logger('********************| Middleware/PermissionMiddleware:handle > end |********************');
        return $next($request);
    }
}
