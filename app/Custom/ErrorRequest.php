<?php

namespace App\Custom;

use Carbon\Carbon;
use Illuminate\Contracts\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response;

class ErrorRequest
{
    /**
     * Manejo de errores para los campos de las peticiones, retorna directamente un json con los errores encontrados
     * @param MessageBag $errors, la lista de errores que arroja Validate()
     * @param string $title, para retornar la api donde se esta ejecutando.
     * 
     * @return json, si se encontraron errores, en caso contrario null
     */
    public static function getErrors(MessageBag $errors, string $title)
    {
        $msgsError = null;
        foreach ($errors->all() as $message) {
            $msgsError[] = $message;
        }
        if (isset($msgsError)) {
            abort(response()->json([
                'status' => 0,
                'title' => $title,
                'errors' => $msgsError,
            ], Response::HTTP_OK));
        }
    }

    /**
     * Manejo de un error generico encontrado por otro tipo de validacion
     * @param string $error, el error que se enviara 
     * @param string $title, para retornar la api donde se esta ejecutando.
     * 
     * @return json, si se encontraron errores, en caso contrario null
     */
    public static function genericErrors(array $errors, string $title)
    {
        abort(response()->json([
            'status' => 0,
            'title' => $title,
            'errors' => $errors,
        ], Response::HTTP_OK));
    }

    /**
     * Validacion para fecha, cuando recibimos fecha de inicio y final, revisar que la inicial no sea mayor que la final
     */
    public static function assertStartAndEndDate($request, $title)
    {
        if ($request->has('start_date') && $request->has('end_date')) {
            $date1 = Carbon::createFromFormat('Y-m-d', $request->start_date);
            $date2 = Carbon::createFromFormat('Y-m-d', $request->end_date);
            if ($date1->gt($date2)) { //gt = greater than
                return self::genericErrors(['Fecha de inicio es mayor a la fecha final'], $title);
            }
        }
        // return null;
    }
}
