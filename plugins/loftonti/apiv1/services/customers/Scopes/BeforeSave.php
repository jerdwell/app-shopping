<?php

namespace LoftonTi\Apiv1\Services\Customers\Scopes;

trait BeforeSave
{

  public function beforeSave()
  {
    $this -> full_name = ucwords($this -> full_name);
    $this -> rfc = strtoupper($this -> rfc);
  }

}