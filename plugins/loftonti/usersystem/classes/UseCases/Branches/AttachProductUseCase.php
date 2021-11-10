<?php

namespace LoftonTi\Usersystem\Classes\UseCases\Branches;

use Loftonti\Erso\Models\Branches;

class AttachProductUseCase  
{

  /**
   * @var object
   */
  private $repository, $product;
  /**
   * @var int
   */
  private $branch_id, $enterprise_id, $stock;

  /**
   * @param int $branch_id
   * @param int $enterprise_id
   * @param int $stock
   * @param object $product
   */
  public function __construct($branch_id, $enterprise_id, $stock, $product) {
    $this->branch_id = $branch_id;
    $this->enterprise_id = $enterprise_id;
    $this->stock = $stock;
    $this->product = $product;
    $this -> repository = new Branches;
  }

  public function __invoke()
  {
    try {
      $branch = $this -> repository -> find($this -> branch_id);
      $branch -> products() -> attach([$this -> product -> id => [
        'stock' => $this -> stock,
        'enterprise_id' => $this -> enterprise_id
      ]]);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}
