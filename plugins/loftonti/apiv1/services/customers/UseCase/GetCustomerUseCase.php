<?php

namespace LoftonTi\Apiv1\Services\Customers\Usecase;

use LoftonTi\Apiv1\Services\Customers\Repositories\CustomersEloquentRepository;

class GetCustomerUseCase
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new CustomersEloquentRepository;
  }

  public function __invoke(int $id)
  {
    $customer = $this 
      -> repository 
      -> get($id);
    if(!$customer) throw new \Exception("Este cliente no existe");
    return $customer;
  }

}