<?php

namespace LoftonTi\Apiv1\Services\Products\Jobs;

use Illuminate\Support\Facades\Mail;

class SyncSuccessNotification
{

  public function fire($job, $data)
  {
  try {
    $sync_data = [
        'products_updateds' => $data['sync_products']['updateds'],
        'products_errors' => $data['sync_products']['errors'],
        'products_errors_data' => $data['sync_products']['errors_data'],
        'stock_updateds' => $data['sync_stock']['updateds'],
        'stock_errors' => $data['sync_stock']['errors'],
        'stock_error_data' => $data['sync_stock']['error_data'],
      ];
      Mail::send('loftonti.usersystem::mail.sync-databases-mail', $sync_data, function ($message) use($data) {
        $message->to('erdwell@gmail.com')
          ->subject('Sincronización de productos.')
          -> attach($data['file_path'], [
            'as' => $data['file_name']
          ]);
      });
    } catch (\Throwable $th) {
      print_r($th -> getMessage());
    }
    $job -> delete();
  }

}