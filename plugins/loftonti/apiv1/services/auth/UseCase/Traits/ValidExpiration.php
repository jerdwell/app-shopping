<?php

namespace LoftonTi\Apiv1\Services\Auth\UseCase\Traits;

trait ValidExpiration
{
  /**
   * get user system by id and check if exists and available
   * @method DecodeToken
   * @param int $id
   */
  private function validExpiration(): void
  {
    try {
      if(time() > $this -> token_decoded -> exp) throw new \Exception("Token has expired");
    } catch (\Throwable $th) {
      throw $th;
    }
  }
}