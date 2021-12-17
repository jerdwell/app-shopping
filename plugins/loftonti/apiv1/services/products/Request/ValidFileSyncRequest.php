<?php

namespace Loftonti\Apiv1\Services\Products\Request;

use Illuminate\Http\Request;

trait ValidFileSyncRequest
{

  public function validFileSyncRequest(Request $request)
  {
    if(!$request -> hasFile('file_sync')) throw new \Exception("No  existe un archivo cargado");
    if($request -> file('file_sync') -> getClientOriginalExtension() != 'csv') throw new \Exception("El archivo que intentas cargar no es de tipo .csv");  }
}