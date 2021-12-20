<?php

namespace LoftonTi\Apiv1\Services\Products\UseCase;

use Loftonti\Apiv1\Services\Products\Repositories\ProductEloquentRepository;

class GetProductByErsoCodeUseCase
{

  /**
   * @var string
   */
  private $erso_code;

  /**
   * @var object
   */
  private $repository;

  public function __construct(string $erso_code) {
    $this -> erso_code = $erso_code;
    $this->repository = new ProductEloquentRepository;
  }

  public function __invoke()
  {
    return $this -> repository -> getByErsoCode($this -> erso_code);
  }

}