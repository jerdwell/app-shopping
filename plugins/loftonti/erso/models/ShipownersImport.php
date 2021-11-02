<?php

namespace Loftonti\Erso\Models;

use Backend\Models\ImportModel;
use Loftonti\Erso\Models\Shipowners;
use Illuminate\Support\Str;

class ShipownersImport extends ImportModel
{

  public $rules = [];

  public function importData($results, $sessionKey = null)
  {
    foreach ($results as $row => $data) {
      try {
        $shipowner = new Shipowners;
        $shipowner -> shipowner_name = $data['shipowner_name'];
        $shipowner -> shipowner_slug = Str::slug($data['shipowner_name']);
        $shipowner -> deleted_at = null;
        $shipowner -> save();
        $this->logCreated();
      } catch (\Exception $ex) {
        $this->logError($row, $ex->getMessage());
      }
    }
  }
}
