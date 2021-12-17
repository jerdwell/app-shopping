<?php

namespace LoftonTi\Apiv1\Services\Products\UseCase;

use Loftonti\Apiv1\Services\Products\Repositories\ProductEloquentRepository;

class CountProductsActiveOfBranchUseCase
{
  /**
   * @var int
   */
  private $branch_id;

  /**
   * @var object
   */
  private $repository;

  /**
   * Get products active of branch
   * @param int $branch_id
   */
  public function __construct(int $branch_id) {
    $this->branch_id = $branch_id;
    $this -> repository = new ProductEloquentRepository;
  }

  /**
   * @return object all_products
   */
  public function __invoke()
  {
    return $products = $this -> repository -> countActivesByBranch($this -> branch_id);
  }
}