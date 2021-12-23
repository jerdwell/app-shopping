<?php

namespace LoftonTi\Apiv1\Services\Customers\Repositories;

use LoftonTi\Apiv1\Services\Customers\Contracts\CustomerContracts;
use LoftonTi\Users\Models\Users as Customer;

class CustomersEloquentRepository implements CustomerContracts
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new Customer;
  }

  public function create(array $customer): object
  {
    $created = $this 
      -> repository
      -> create($customer);
    $created 
      -> address()
      -> create($customer['address']);
    $created -> address;
    return $created;
  }

}