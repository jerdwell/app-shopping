<?php

namespace LoftonTi\Apiv1\Services\Enterprises\Repositories;

use LoftonTi\Apiv1\Services\Enterprises\Contracts\EnterprisesContracts;
use Loftonti\Erso\Models\Enterprises;

class EnterpriseEloquentRepository implements EnterprisesContracts
{
  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new Enterprises;
  }


  /**
   * return all enterprises 
   * @method all
   */
  public function all(): object
  {
    return $this -> repository -> all();
  }
}