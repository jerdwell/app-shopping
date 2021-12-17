<?php

namespace LoftonTi\Apiv1\Services\Products\Jobs;

use LoftonTi\Apiv1\Services\Products\UseCase\PrepareProductsToSyncDatabaseUseCase;

class SyncFileJob
{

  /**
   * dispatch events
   * @method
   */
  public function fire($job, $data) {
    new PrepareProductsToSyncDatabaseUseCase($data['branch_id'], $data['file_name']);
    $job ->delete();
  }

}