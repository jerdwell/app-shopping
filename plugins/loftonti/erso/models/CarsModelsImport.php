<?php
namespace Loftonti\Erso\Models;

use Backend\Models\ImportModel;
use Loftonti\Erso\Models\CarsModels;
use Illuminate\Support\Str;

class CarsModelsImport extends ImportModel
{

  public $rules = [];

  public function importData($results, $sessionKey = null)
  {
    foreach ($results as $row => $data) {
      try {
        $car = new CarsModels;
        $car -> car_name = $data['car_name'];
        $car -> car_slug = Str::slug($data['car_name']);
        $car -> deleted_at = null;
        $car -> save();
        $this->logCreated();
      } catch (\Exception $ex) {
        $this->logError($row, $ex->getMessage());
      }
    }
  }
  
}
