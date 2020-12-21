<?php namespace Loftonti\Erso\Models;

use Backend\Models\ImportModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Loftonti\Erso\Models\{Categories, Products, Shipowners, Enterprises, Brands, CarsModels, ErsoCodes, Applications};
use Illuminate\Support\Str;
use PDO;

class ApplicationsImport extends ImportModel
{

  public $rules = [];

  public function importData($results, $sessionKey = null)
  {
    try {
      $codes = Products::get();
      $codes = collect($codes);
      $shipowners = Shipowners::all();
      $cars = CarsModels::all();
      $shipowners = collect($shipowners); 
      $cars = collect($cars);
      $applications = [];
      $fails = [];
      foreach ($results as $row => $data) {
        if($data['erso_code'] != ''){
          $shipowner = $shipowners -> firstWhere('shipowner_slug', Str::slug($data['shipowner']));
          $car = $cars -> firstWhere('car_slug', Str::slug($data['car']));
          $product = $codes -> firstWhere('erso_code', $data['erso_code']);
          if($product && $car && $shipowner){
            $application = [
              'product_id' => $product -> id,
              'car_id' => $car -> id,
              'shipowner_id' => $shipowner -> id,
              'year' => $data['year'],
              'note' => $data['note'],
            ];
            array_push($applications, $application);
            $this -> logCreated();
          }else{
            $data['error'] = '';
            $data['error'] .= !$product ? 'Éste código no existe, ' : null;
            $data['error'] .= !$car ? 'Éste auto no existe, ' : null;
            $data['error'] .= !$shipowner ? 'Ésta armadora no existe, ' : null;
            array_push($fails, $data);
            $this -> logWarning($row, json_encode($data));
          }
        }
      }
      if(count($fails) > 0){
        Mail::send('loftonti.erso::mail.application-errors', ['fails' => $fails], function($message){
          $message->to(['erdwell@gmail.com', 'administrativo2@erso.com.mx', 'administrativo1@erso.com.mx'], 'Sistema Erso');
          $message->subject('Errores en la carga de productos.');
        });
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