<?php

/**
 * Created by Sergio Ruiz Orodea.
 */

namespace App\Imports;

use App\Models\BienInteresCultural;
use App\Models\Localidad;
use App\Models\Municipio;
use App\Models\Provincia;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

/**
 * Class BienCulturalImport
 *
 * @package App\Imports
 */
class BienCulturalImport implements ToModel
{
    /**
     * Función que importa los bienes de interés cultural a través del Excel
     *
     * @param array $fila
     *
     * @return BienCulturalImport|null
     */
    public function model(array $fila)
    {
        $texto_provincia = trim($fila[2]);
        $existe_provincia = Provincia::where('nombre','=',$texto_provincia)->get();
        if(count($existe_provincia) > 0){
            $provincia_id = $existe_provincia[0]->id;
        }else{
            $new_provincia = new Provincia();
            $new_provincia->nombre = $texto_provincia;
            $new_provincia->save();
            $provincia_id = $new_provincia->id;
        }
        $texto_municipio = trim($fila[1]);
        $existe_municipio = Municipio::where('nombre','=',$texto_municipio)->get();
        if(count($existe_municipio) > 0){
            $municipio_id = $existe_municipio[0]->id;
        }else{
            $new_municipio = new Municipio();
            $new_municipio->nombre = $texto_municipio;
            $new_municipio->provincia_id = $provincia_id;
            $new_municipio->save();
            $municipio_id = $new_municipio->id;
        }
        $texto_localidad = trim($fila[0]);
        $existe_localidad = Localidad::where('nombre','=',$texto_localidad)->get();
        if(count($existe_localidad) > 0){
            $localidad_id = $existe_localidad[0]->id;
        }else{
            $new_localidad = new Localidad();
            $new_localidad->nombre = $texto_localidad;
            $new_localidad->municipio_id = $municipio_id;
            $new_localidad->save();
            $localidad_id = $new_localidad->id;
        }
        return new BienInteresCultural([
           'nombre'         => trim($fila[3]),
           'provincia_id'   => $provincia_id,
           'localidad_id'   => $localidad_id,
           'municipio_id'   => $municipio_id,
        ]);
    }
}