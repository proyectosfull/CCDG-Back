<?php

namespace App\Custom;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\assertNotEmpty;

class File extends Model
{
    /**
     * IMPORTANTE
     * esta funcion se basa en la app_url del env, si tiene localhost, no servira, cambiar a 127.0.0.1
     */
    public static function getPublicPath()
    {
        return Storage::disk('public_files')->url('');
    }

    /**
     * método que elimina un archivo de la ruta publica (app/public/storage/../path_file) independientemente de sus carpetas subsiguientes
     * y retorna un string con el status del archivo, si se pudo eliminar o no fue encontrado.
     * @param string $path_file
     * @return $msg
     */
    public static function deleteFile(?string $path_file)
    {
        if (is_null($path_file) || empty($path_file)) return '';
        //se obtiene el nombre del archivo sin la ruta publica
        $filename = str_replace(self::getPublicPath(), '', $path_file);
        //se elimina archivo del almacenamiento publico
        $removed = Storage::disk('public_files')->delete($filename);
        return (' file: ' . $filename . ($removed ? ' removed' : ' not found'));
    }

    /**
     * método para crea un archivo en la ruta publica (app/public/storage), el archivo sera creado con los parametros proporcionados
     * por defecto, despues del $prev_name se insertara la fecha con formato: ('Y_m_d_H_i_s') y luego el filename, en la $path especificada
     * @param file $file, si no viene retorna un string vacio, 
     * @param string $prev_name, para uso de algún identificador y tener ordenado
     * @param string $filename, nombre del archivo con extension.
     * @param string $path, string que sera el conjuntos de carpetas donde se creara el archivo
     * @return string $full_path, si esta vacio, ocurrio un error al crear o el archivo base esta vacio.
     */
    public static function createFile($file, $prev_name, $filename, $path)
    {
        // Replace spaces with underscores
        $label = preg_replace('/\s+/', '_', $filename);
        if (!empty($file)) {
            // Get the file extension
            $oldExtension = $file->extension();
            $name = ($prev_name ? $prev_name . '_' : '') . Carbon::now()->timezone('America/Mexico_City')->format('Y_m_d_H_i_s') . '_' . $label . "." . $oldExtension;
            // Save file @param1: ruta, @param2: nombre, @param3: disk [local o public]
            $file->storeAs($path . '/', $name, 'public');
            return asset('storage/' . $path . '/' . $name); //la url completa del archivo
        }
        return '';
    }

    /**
     * método para crea un archivo en la ruta publica (app/public/storage), el archivo sera creado con los parametros proporcionados
     * por defecto, despues del $prev_name se insertara la fecha con formato: ('Y_m_d_H_i_s') y luego el filename, en la $path especificada
     * @param file $file, si no viene retorna un string vacio, 
     * @param string $prev_name, para uso de algún identificador y tener ordenado
     * @param string $path, string que sera el conjuntos de carpetas donde se creara el archivo
     * @return string $full_path, si esta vacio, ocurrio un error al crear o el archivo base esta vacio.
     */
    public static function createFileWithOriginalName($file, $prev_name, $path)
    {
        if (!empty($file)) {
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            // Replace spaces with underscores
            $label = preg_replace('/\s+/', '_', $filename);
            // Get the file extension
            $oldExtension = $file->extension();
            $name = ($prev_name ? $prev_name . '_' : '') . Carbon::now()->timezone('America/Mexico_City')->format('Y_m_d_H_i_s') . '_' . $label . "." . $oldExtension;
            // Save file @param1: ruta, @param2: nombre, @param3: disk [local o public]
            $file->storeAs($path . '/', $name, 'public');
            return asset('storage/' . $path . '/' . $name); //la url completa del archivo
        }
        return '';
    }

    /**
     * Reemplaza el archivo anterior, con el nuevo que es pasado por parametro, y retorna la ruta completa
     * para que pueda ser guardado en la BD
     *
     * @param Uploadedfile $file, archivo nuevo
     * @param string $previous_file
     * @param string $root_path
     * @param string $prev_name
     * @param string $filename
     * @return string $msg
     */
    public static function replace_file(UploadedFile $new_file, ?string $previous_file, string $root_path, string $prev_name, string $filename, &$msg)
    {
        $path = self::createFile($new_file, $prev_name, $filename, $root_path);
        if (!empty($path)) {
            //se obtiene el nombre del archivo sin la ruta publica, para eliminarlo
            $result = File::deleteFile($previous_file);
            //si no esta vacio es porque elimino el archivo correctamente y se notifica
            if(!empty($result)){
                $msg[] = 'Status' . $result;
            }
        }
        return $path ?? '';
    }

        /**
     * Reemplaza el archivo anterior, con el nuevo que es pasado por parametro, y retorna la ruta completa
     * para que pueda ser guardado en la BD
     *
     * @param Uploadedfile $file, archivo nuevo
     * @param string $previous_file
     * @param string $root_path
     * @param string $prev_name
     * @param string $filename
     * @return string $msg
     */
    public static function replace_fileWithOriginalName(UploadedFile $new_file, string $previous_file, string $root_path, string $prev_name, &$msg)
    {
        $file = $new_file->getClientOriginalName();
        $filename = pathinfo($file, PATHINFO_FILENAME);
        $path = self::createFile($new_file, $prev_name, $filename, $root_path);
        if (!empty($path)) {
            //se obtiene el nombre del archivo sin la ruta publica, para eliminarlo
            $msg[] = 'Status' . File::deleteFile($previous_file);
        }
        return $path ?? '';
    }
}
