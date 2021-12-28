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
    unset($customer['created_at']);
    unset($customer['updated_at']);
    unset($customer['password']);
    unset($customer['email_verified_at']);
    unset($customer['address']['user_id']);
    return $this
      -> repository
      -> update($customer);
  }

}