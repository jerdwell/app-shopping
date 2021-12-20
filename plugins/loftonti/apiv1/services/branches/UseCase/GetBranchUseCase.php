<?php

namespace LoftonTi\Apiv1\Services\Branch\UseCase;

use LoftonTi\Apiv1\Services\Branches\Repositories\BranchEloquentrepository;

class getBranchUseCase
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

  public function __invoke()
  {
    return $this -> repository -> getById($this -> branch_id);
  }

}