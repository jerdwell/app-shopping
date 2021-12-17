<?php

namespace LoftonTi\Apiv1\Services\Products\Controllers;

use Illuminate\Support\Facades\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Loftonti\Apiv1\Services\Products\Request\ValidFileSyncRequest;

class SyncFileController
{
  use ValidFileSyncRequest;
  /**
   * @var int
   */
  private $branch_id;

  public function __invoke(Request $request)
  {
    try {
      $this -> validFileSyncRequest($request);
      $file = $request -> file('file_sync');
      $file_name = explode('.', $file -> hashName())[0] . '.csv';
      Storage::putFileAs('private/sync-files/branch/' . $request -> branch_id, $file, $file_name);
      Queue::push('LoftonTi\Apiv1\Services\Products\Jobs\SyncFileJob', [
        'branch_id' => $request -> branch_id,
        'file_name' => $file_name
      ]);
      return response() -> json([
        'message' => 'El archivo se ha cargado exitosamente, te notificaremos por correo cuando se haya procesado la información.'
      ], 200);
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ], 400);
    }
  }
}