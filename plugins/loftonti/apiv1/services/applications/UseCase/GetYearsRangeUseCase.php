<?php

namespace LoftonTi\Apiv1\Services\Applications\Usecase;

use LoftonTi\Apiv1\Services\Applications\Repositories\ApplicationsEloquentRepository;

class GetYearsRangeUseCase
{
  /**
   * @var int
   */
  private $car, $shipowner;

  /**
   * @var object
   */
  private $repository;

  public function __construct(?int $car, ?int $shipowner) {
    $this -> car = $car;
    $this -> shipowner = $shipowner;
    $this->repository = new ApplicationsEloquentRepository;
  }

  public function __invoke()
  {
    return $this -> repository -> getRangeYears($this -> car, $this -> shipowner);
  }

}