<?php namespace LoftonTi\Users\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Model;
use LoftonTi\Users\Models\Users;

class UsersAuth extends Model
{

  public static function MakeToken($user_id)
  {
    try {
      $user = Users::find($user_id);
      if($user -> deleted_at) throw new \Exception('Datos incorrectos');
      if(!$user -> mail_confirm) throw new \Exception('Datos incorrectos');
      $data_token = [
        'id' => $user -> id,
        'type' => $user -> type,
        'name' => $user -> firstname . ' ' . $user -> lastname,
        'sk' => Hash::make($user -> token_remember),
        'expires' => Carbon::now() -> addHour(4) -> format('Y-m-d H:i:s')
      ];
      $token = [
        'name' => $user -> firstname . ' ' . $user -> lastname,
        'type' => $user -> type,
        'token' => Crypt::encryptString(json_encode($data_token)),
        'expire' => Carbon::now() -> addHour(4) -> format('Y-m-d H:i:s')
      ];
      return $token;
    } catch (\Exception $th) {
      throw $th -> getMessage();
    }
  }

  public static function validRequest($request)
  {
    $token = $request -> header('Authorization');
    if(!$token) throw new \Exception('Credenciales inválidas');
    $token_decripted =  Crypt::decryptString(str_replace('Bearer ', '', $token));
    $data_token = json_decode($token_decripted);
    if(!$data_token -> id) throw new \Exception('Credenciales inválidas');
    $user = Users::find($data_token -> id);
    if(empty($user)) throw new \Exception('Credenciales inválidas');
    if($user -> deleted_at) throw new \Exception('Credenciales inválidas');
    if(!$user -> mail_confirm) throw new \Exception('Credenciales inválidas');
    if(!Hash::check($user -> token_remember, $data_token -> sk)) throw new \Exception('Credenciales inválidas');
    $request -> request -> add([
      'data_user' => [
        'id' => $user -> id,
        'name' => $user -> firstname . ' ' . $user -> lastname,
      ],
    ]);
  }
  
}
