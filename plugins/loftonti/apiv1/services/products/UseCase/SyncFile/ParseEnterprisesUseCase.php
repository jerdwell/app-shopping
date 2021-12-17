<?php

namespace LoftonTi\Apiv1\Services\Products\UseCase\SyncFile;

use LoftonTi\Apiv1\Services\Enterprises\Usecase\GetEnterprisesUseCase;

trait ParseEnterprisesUseCase
{

  /**
   * Parse enterprises and set id's by rfc
   * @method parseEnterprises
   */
  public function parseEnterprises()
  {
    $enterprises = new GetEnterprisesUseCase;
    $enterprises = $enterprises();
    foreach ($enterprises as $enterprise) {
      $this -> enterprises[$enterprise -> rfc] = $enterprise -> id;
    }
    unset($enterprises);
  }

}