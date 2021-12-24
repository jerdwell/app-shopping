<?php

namespace LoftonTi\Apiv1\Services\Customers\Usecase;

use LoftonTi\Apiv1\Services\Customers\Repositories\CustomersEloquentRepository;

class ListCustomersUseCase
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new CustomersEloquentRepository;
  }

  public function __invoke(?int $per_page, ?string $order, ?string $order_by, ?string $param)
  {
    $per_page = $per_page ? $per_page : 100;
    $order = $order ? $order : 'asc';
    $order_by = $order_by ? $order_by : 'id';
    return $this
      -> repository
      -> list($per_page, $order, $order_by, $param);
  }

}