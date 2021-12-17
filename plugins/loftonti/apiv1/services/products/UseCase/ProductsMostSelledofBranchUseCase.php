<?php

namespace Loftonti\Apiv1\Services\Products\UseCase;

use Loftonti\Apiv1\Services\Products\Repositories\ProductEloquentRepository;

class ProductsMostSelledofBranchUseCase
{

  /**
   * @var int
   */
  private $branch_id;

  /**
   * @var object
   */
  private $repository;

  public function __construct(int $branch_id) {
    $this -> branch_id = $branch_id;
    $this -> repository = new ProductEloquentRepository;
  }

  public function __invoke()
  {
    return $this -> repository -> getProductsMostSelledByBranch($this -> branch_id);
  }

}