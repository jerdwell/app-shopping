<?php
namespace LoftonTi\Apiv1\Services\Applications\Repositories;

use Illuminate\Support\Facades\DB;
use LoftonTi\Apiv1\Services\Applications\Contracts\ApplicationsContracts;

class ApplicationsEloquentRepository implements ApplicationsContracts
{

  /**
   * @var string
   */
  private $table = 'loftonti_erso_application';

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = DB::table($this -> table);
  }

  public function getRangeYears(?int $car, ?int $shipowner): object
  {
    return $this -> repository
      -> selectRaw("MIN(SUBSTRING_INDEX(year, '-', 1)) as start, 
      MAX(SUBSTRING_INDEX(year, '-', -1)) as end")
      -> when($car, function($car_query) use($car){
        $car_query -> where('car_id', $car);
      })
      -> when($shipowner, function($shipowner_query) use($shipowner){
        $shipowner_query -> where('shipowner_id', $shipowner);
      })
      -> take(1)
      -> get();
  }

}