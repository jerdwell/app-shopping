<?php namespace Loftonti\Erso\Models;

use Backend\Models\ImportModel;

use Loftonti\Erso\Models\Brands;
use Illuminate\Support\Str;

class BrandsImport extends ImportModel {

  public $rules = [];

  public function importData($results, $sessionKey = null)
  {
    foreach ($results as $row => $brand) {
      try {
        $brands = new Brands;
        $brands -> brand_name = $brand['brand_name'];
        $brands -> brand_slug = Str::slug($brand['brand_name']);
        $brands -> brand_cover = null;
        $brands -> brand_logo = null;
        $brands -> deleted_at = null;
        $brands -> save();
        $this->logCreated();
      } catch (\Throwable $ex) {
        $this->logError($row, $ex->getMessage());
      }
    }

  }

}