<?php namespace Loftonti\Users\Models;

use Backend\Models\ImportModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Loftonti\Erso\Models\{Categories, Products, Shipowners, Enterprises, Brands, CarsModels, ErsoCodes};
use Illuminate\Support\Str;
use LoftonTi\Users\Models\Users;

class UsersImport extends ImportModel
{

  public $rules = [];
  
  public function importData($results, $sessionKey = null)
  {
    foreach ($results as $row => $data) {
      try {
        $this -> validUser($data);
        $users = new Users;
        $user = $users -> where('email', $data['email']) -> first();
        if(!empty($user)) throw new \Exception("El usuario {$data['email']} ya existe");
        $data_user = [
          "firstname" => $data['firstname'],
          "lastname" => $data['lastname'],
          "email" => $data['email'],
          "token_remember" => Str::random(30),
          "password" => Hash::make(Str::random(16)),
          "phone" => $data['phone'],
          "mail_confirm" => true
        ];
        $address_user = [
          "address1" => $data['address1'],
          "suburb" => $data['suburb'],
          "zip_code" => $data['zip_code'],
          "state" => $data['state'],
          "city" => "México",
          "country" => $data['country'],
          "address2" => $data['address2'],
        ];
        $m = Users::getEventDispatcher();
        Users::unsetEventDispatcher();
        $this->unbindEvent( 'Users.afterCreate' );
        $u = $users -> create($data_user);
        $u -> address() -> create($address_user);
        Users::setEventDispatcher($m);
        $this -> logCreated();
      } catch (\Exception $ex) {
        $this->logError($row, $ex -> getMessage());
      }
    }
  }

  public function validUser($data)
  {
    if(
      $data['firstname'] == '' ||
      $data['lastname'] == '' ||
      $data['email'] == '' ||
      $data['phone'] == '' ||
      $data['address1'] == '' ||
      $data['suburb'] == '' ||
      $data['zip_code'] == '' ||
      $data['state'] == '' ||
      $data['country'] == ''
    ){
      throw new \Exception("Los datos no están completos");
    }
  }
  

}