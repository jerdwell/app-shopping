<?php

namespace LoftonTI\Usersystem\Classes\UseCases;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use LoftonTi\Usersystem\Models\UserSystem;

class AuthUserUseCase
{

  /**
   * @var string
   */
  private
    $username, 
    $password,
    $sk,
    $pk,
    $name;
  /**
   * @var int
   */
  private $id;
  /**
   * @var object
   */
  private $rol, $branches, $avatar;

  public function __construct(string $username, string $password)
  {
    $this->username = $username;
    $this->password = $password;
    $this -> dataValidations();
    $this -> validPassword();
  }

  /**
   * Valid if the params for login user exists and meet the requirements
   * @method
   */
  private function dataValidations(): void
  {
    try {
      $valid = Validator::make([
        'username' => $this->username,
        'password' => $this->password
      ], [
        'username' => 'required|string|min:5|max:200',
        'password' => 'required|string|min:8|max:200',
      ], [
        'username.*' => 'El nombre de usuario es un dato requerido y debe contener al menos 5 dígitos.',
        'password.*' => 'La contraseña es un dato requerido y debe contener al menos 8 dígitos.'
      ]);
      if ($valid->fails()) {
        if ($valid->errors()->has('username')) throw new \Exception($valid->errors()->get('username')[0]);
        if ($valid->errors()->has('password')) throw new \Exception($valid->errors()->get('password')[0]);
      }
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * valid if the username and passwor matched
   * @method
   */
  private function validPassword():void
  {
    try {
      $error_message = "Datos erroneos.";
      $user = UserSystem::where('username', $this -> username)
        -> first();
      if( !$user ) throw new \Exception($error_message);
      if( !Hash::check($this -> password, $user -> password)) throw new \Exception($error_message);
      
      $user -> rol;
      $user -> rol -> makeHidden(['description', 'deleted_at', 'updated_at', 'created_at']);
      $user -> rol -> modules;
      $user -> branches;
      $user -> branches;
      $user -> rol -> modules -> makeHidden(['description', 'created_at', 'updated_at', 'deleted_at', 'id']);
      $user -> avatar;
      $this -> rol = $user -> rol;
      $this -> name = $user -> firstname . ' ' . $user -> lastname;
      $this -> sk = $user -> sk;
      $this -> pk = $user -> pk;
      $this -> id = $user -> id;
      $this -> branches = $user -> branches;
      $this -> avatar = $user -> avatar;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function getRol(): object
  {
    return $this -> rol;
  }
  
  public function getBranches(): object
  {
    return $this -> branches;
  }

  public function getName(): string
  {
    return $this -> name;
  }
  
  public function getPk(): string
  {
    return $this -> pk;
  }
  
  public function getSk(): string
  {
    return $this -> sk;
  }
  
  public function getId(): int
  {
    return $this -> id;
  }
  
  public function getAvatar()
  {
    return $this -> avatar;
  }

}
