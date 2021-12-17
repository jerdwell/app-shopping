<?php

namespace LoftonTi\Apiv1\Services\Enterprises\Controllers;

use LoftonTi\Apiv1\Services\Enterprises\Repositories\EnterpriseEloquentRepository;

class GetEnterprisesUseCase
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this -> repository = new EnterpriseEloquentRepository;
  }

  public function __invoke()
  {
    return $this -> repository -> all();
  }

}