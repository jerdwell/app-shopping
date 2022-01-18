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

  public function get(int $id): ?object
  {
    return $this
      -> repository
      -> with([
        'address'
      ])
      -> find($id);
  }

  public function list(?int $per_page, ?string $order, ?string $order_by, ?string $param): object
  {
    return $this 
      -> repository
      ->when($param, function($q) use($order_by, $param){
        return $q -> where($order_by, "like", "%{$param}%");
      })
      -> orderBy($order_by, $order)
      -> paginate($per_page);
  }

  public function update(array $customer): ?object
  {
    $customer_entity = $this -> repository -> find($customer['id']);
    $customer_entity -> update($customer);
    $customer_entity -> address()
      -> update($customer['address']);
    $customer_entity -> address;
    return $customer_entity;
  }

  public function getBycol(string $col, string $value): ?object
  {
    $customer_entity = $this -> repository 
      -> where($col, $value)
      -> first();
    return $customer_entity;
  }

  public function search(string $data): ?object
  {
    return $this -> repository
      -> where('email', 'like', "%$data%")
      -> orWhere('rfc', 'like', "%$data%")
      -> orWhere('phone', 'like', "%$data%")
      -> with(['address'])
      -> limit(10)
      -> get();
  }

}