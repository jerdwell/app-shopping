<?php namespace Loftonti\Erso\Models;

use Backend\Models\ImportModel;

class ProductsImport extends ImportModel
{

  public $rules = [];
  
  public function importdata($results, $sessionKey = null)
  {
    
    $data = [];
    foreach ($results as $row) {
      try {
        array_push($data,$results);
      } catch (\Exception $ex) {
        $this->logError($row, $ex -> getMessage());
      }
    }
    return $data;
    
  }

}