<?php

namespace LoftonTi\Apiv1\Services\Products\Jobs;

use Illuminate\Support\Facades\Mail;

class SyncThrowNotificationJob
{

  public function fire($job, $data)
  {
    try {
      Mail::send('loftonti.usersystem::mail.fails-sync-databases-mail', [
        'errors' => $data['errors']
      ], function ($message)  use ($data) {
        $message->to('erdwell@gmail.com')
          ->subject('Sincronización de productos.')
          -> attach($data['file_path'], [
            'as' => $data['file_name']
          ]);
      });
    } catch (\Throwable $th) {
      throw $th;
    }
    $job->delete();
    unlink($data['file_path']);
  }

}