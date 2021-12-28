<?php

namespace LoftonTi\Apiv1\Services\Customers\Usecase;

use LoftonTi\Apiv1\Services\Customers\Repositories\CustomersEloquentRepository;

class UpdateCustomerUseCase
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new CustomersEloquentRepository;
  }

  public function __invoke(array $customer)
  {
    return $this
      -> repository
      -> update($customer);
  }

}