<?php

namespace LoftonTi\Apiv1\Services\Customers\Usecase;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use LoftonTi\Apiv1\Services\Customers\Repositories\CustomersEloquentRepository;

class CreateCustomerUseCase
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new CustomersEloquentRepository;
  }

  public function __invoke(array $customer, string $type)
  {
    $customer['type'] = $type;
    $customer['pk'] = Str::random(32);
    $customer['sk'] = Str::random(32);
    $customer['password'] = Hash::make($customer['password']);
    return $this -> repository -> create($customer);
  }

}