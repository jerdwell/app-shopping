<?php

namespace LoftonTi\Apiv1\Services\Customers\Usecase;

use LoftonTi\Apiv1\Services\Customers\Repositories\CustomersEloquentRepository;

class GetCustomerByColUseCase
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new CustomersEloquentRepository;
  }

  /**
   * @method to get customer by column match
   */
  public function __invoke(string $col, string $value): ?object
  {
    return $this -> repository -> getByCol($col, $value);
  }

}