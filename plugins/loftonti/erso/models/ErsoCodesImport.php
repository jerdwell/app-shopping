<?php namespace Loftonti\Erso\Models;

use Backend\Models\ImportModel;
use Illuminate\Support\Str;
use Loftonti\Erso\Models\{ ErsoCodes };

class ErsoCodesImport extends ImportModel{

  public $rules = [];

  public function importData($results,$sessionKey = null)
  {
    set_time_limit(6000);
    // ini_set('max_execution_time', 1800);

    foreach ($results as $row => $data) {
      try {
        $ersoCodes = new ErsoCodes;
        $code = Str::slug($data['erso_code']);
        $code = Str::upper($code);
        $code_exists = $ersoCodes -> where('erso_code', $code) -> get();
        if(count($code_exists) > 0) throw new \Exception("El código {$code} no se ha registrado porque ya existe.");
        $ersoCodes -> erso_code = $code;
        $ersoCodes -> deleted_at = null;
        $ersoCodes -> save();
        $this -> logCreated();
        
      } catch (\Exception $th) {
        $this->logError($row, $th -> getMessage());
      }
    }
  }

}