<?php

namespace LoftonTi\Apiv1\Services\Shoppings\UseCase;

use LoftonTi\Apiv1\Services\Shoppings\Repositories\ShoppingEloquentRepository;

class UpdateOrderStatusUseCase
{
  /**
   * @var int
   */
  private $id;

  /**
   * @var string
   */
  private $status, $notes;

  /**
   * @var object
   */
  private $repository;

  public function __construct(int $id, string $status, ?string $notes) {
    $this->id = $id;
    $this->status = $status;
    $this->notes = $notes;
    $this -> repository = new ShoppingEloquentRepository;
  }

  public function __invoke()
  {
    return $this -> repository -> updateStatus(
      $this -> id,
      $this -> status,
      $this -> notes);
  }

}