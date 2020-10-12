<?php namespace Loftonti\Erso\Models;

use Backend\Models\ImportModel;
use Illuminate\Support\Facades\DB;
use Loftonti\Erso\Models\{Categories, Products, Shipowners, Enterprises, Brands, CarsModels, ErsoCodes, Applications};
use Illuminate\Support\Str;
use PDO;

class ApplicationsImport extends ImportModel
{

  public $rules = [];

  public function importData($results, $sessionKey = null)
  {
    try {
      $shipowners = Shipowners::all();
      $cars = CarsModels::all();
      $shipowners = collect($shipowners); 
      $cars = collect($cars);
      $applications = [];
      foreach ($results as $row => $data) {
        if($data['product_id'] != ''){
          $shipowner = $shipowners -> firstWhere('shipowner_slug', Str::slug($data['shipowner']));
          $car = $cars -> firstWhere('car_slug', Str::slug($data['car']));
          $application = [
            'product_id' => $data['product_id'],
            'car_id' => $car -> id,
            'shipowner_id' => $shipowner -> id,
            'year' => $data['year'],
            'note' => $data['note'],
          ];
          array_push($applications, $application);
          $this -> logCreated();
        }
      }
      DB::connection()->getPdo() === (new Applications)->getConnection()->getPdo(); // true
      DB::connection()->getPdo()->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
      Applications::insert($applications);
      DB::connection()->getPdo()->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (\Exception $ex) {
      $this->logError($row, $ex -> getMessage());
    }
  }
  
}