<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Usecase;

use LoftonTi\Apiv1\Services\Shoppings\Repositories\ShoppingEloquentRepository;

class ListShoppingsUseCase
{
  /**
   * @var string
   */
  private $begin = '',
          $end = '',
          $order = 'asc';
  /**
   * @var null|int
   */
  private $branch_id = '',
          $customer_id = '',
          $limit;
  /**
   * @var object
   */
  private $repository;

  public function __construct(string $begin, string $end, string $order = "asc", ?int $branch_id, ?int $customer_id, int $limit) {
    $this->begin = $begin;
    $this->end = $end;
    $this->order = $order;
    $this->branch_id = $branch_id;
    $this->customer_id = $customer_id;
    $this->limit = $limit;
    $this -> repository = new ShoppingEloquentRepository;
  }

  public function __invoke()
  {
    return $this -> repository -> list(
      $this -> begin, 
      $this -> end, 
      $this -> order, 
      $this -> branch_id, 
      $this -> customer_id, 
      $this -> limit);
  }

}