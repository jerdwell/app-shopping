<?php

namespace LoftonTi\Usersystem\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use LoftonTi\Usersystem\Classes\UseCases\Products\GetDasboardDataUseCase;

class UserSystemProductsHandler  
{

  /**
   * @method get data dashboard
   */
  public function dashboardData(Request $request)
  {
    try {
      $dashboard = new GetDasboardDataUseCase($request -> branch_id);
      return $dashboard();
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ], 403);
    }
  }

  /**
   * @method
   */
  public function uploadFileSync(Request $request)
  {
    try {
      if(!$request -> hasFile('file_sync')) throw new \Exception("No  existe un archivo cargado");
      $file = $request -> file('file_sync');
      if($file -> getClientOriginalExtension() != 'csv') throw new \Exception("El archivo que intentas cargar no es de tipo .csv");
      $file_name = explode('.', $file -> hashName())[0] . '.csv';
      Storage::putFileAs('private/sync-files/branch/' . $request -> branch_id, $file, $file_name);
      Queue::push('LoftonTi\Usersystem\Classes\UseCases\Products\PrepareProductsToSyncDatabaseUseCase', [
        'branch_id' => $request -> branch_id,
        'file_name' => $file_name
      ]);
      return response() -> json([
        'message' => 'El archivo se ha cargado exitosamente, te notificaremos por correo cuando se haya procesado la información.'
      ], 200);
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ]);
    }
  }
  
}
