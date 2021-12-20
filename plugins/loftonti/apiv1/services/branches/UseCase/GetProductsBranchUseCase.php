<?php

namespace LoftonTi\Apiv1\Services\Branches\UseCase;

use LoftonTi\Apiv1\Services\Branches\Repositories\BranchEloquentrepository;

class GetProductsBranchUseCase
{

  /**
   * @var int
   */
  private $branch_id;

  /**
   * @var object
   */
  private $respository;

  public function __construct(int $branch_id) {
    $this->branch_id = $branch_id;
    $this -> repository = new BranchEloquentrepository;
  }

  /**
   * @param int $data[per_page]
   * @param string $data[order_by]
   * @param string $data[order]
   * @param string $data[param]
   */
  public function __invoke(array $data)
  {
    return $this -> repository -> getBranchProducts($this -> branch_id, $data);
  }

}