<?php

namespace LoftonTi\Apiv1\Services\Customers\Usecase;

use LoftonTi\Apiv1\Services\Customers\Repositories\CustomersEloquentRepository;

class SearchCustomerUseCase
{
  /**
   * @var object
   */
  private $repository;
  /**
   * @var string
   */
  private $search_data;

  public function __construct(string $search_data) {
    $this -> search_data = $search_data;
    $this->repository = new CustomersEloquentRepository;
  }

  function __invoke()
  {
    return $this -> repository
      -> search($this -> search_data);
  }

}