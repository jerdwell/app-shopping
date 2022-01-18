<?php

namespace LoftonTi\Apiv1\Services\Products\UseCase;

use Loftonti\Apiv1\Services\Products\Repositories\ProductEloquentRepository;

class SearchProductsUseCase
{
  /**
   * @var null|int
   */
  private $car, $shipowner, $category, $brand, $year;

  /**
   * @var null|string
   */
  private $erso_code;

  /**
   * @var object
   */
  private $repository;

  public function __construct(?int $car, ?int $shipowner, ?int $category, ?int $brand, ?int $year, ?string $erso_code) {
    $this->car = $car;
    $this->shipowner = $shipowner;
    $this->category = $category;
    $this->brand = $brand;
    $this->year = $year;
    $this->erso_code = $erso_code;
    $this -> repository = new ProductEloquentRepository;
  }

  public function __invoke()
  {
    return $this -> repository
      -> search(
        $this->car,
        $this->shipowner,
        $this->category,
        $this->brand,
        $this->year,
        $this -> erso_code
      );
  }

}