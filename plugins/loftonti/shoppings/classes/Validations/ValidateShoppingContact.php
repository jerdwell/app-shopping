<?php

namespace LoftonTi\Shoppings\Classes\Validations;

use Illuminate\Support\Facades\Validator;

class ValidateShoppingContact
{

  /**
   * @var array
   */
  private $shopping_contact;


  public function __construct(array $shopping_contact) {
    $this->shopping_contact = $shopping_contact;
    $this -> validate();
  }

  private function validate(): void
  {
    try {
      $valid = Validator::make($this -> shopping_contact, [
        'address1' => 'required|string|min:2|max:200',
        'suburb' => 'required|string|min:2|max:100',
        'zip_code' => 'required|digits:5',
        'state' => 'required|string|min:1|max:200',
        'city' => 'required|string|min:1|max:200',
        'country' => 'required|string|min:2|max:200',
        'fullname' => 'required|string|min:2|max:250',
        'phone' => 'required|email',
        'phone' => 'required|digits:10',
        'address2' => 'nullable|string|min:1|max:200',
      ], [
        'address1.*' => 'La dirección es un dato requerido y no puede contener más de 200 caracteres.',
        'suburb.*' => 'La colonia es in dato requerido y no puede contener más de 100 caracteres.',
        'zip_code.*' => 'El código postal en un dato requerido y debe contener 5 dígitos exactamente.',
        'state.*' => 'El estado es un dato requerido y debe contener un máximo de 200 caracteres.',
        'city.*' => 'La ciudad es un dato requerido y debe contener un máximo de 200 caraceres',
        'country.*' => 'El país es un dato requerido y debe contener un máximo de 200 caracteres.',
        'fullname.*' => 'El nombre es un dato requerido y debe contener un máximo de 250 caracteres.',
        'email.*' => 'El correo es un dato requerido, este elemeto no contiene la estructura correcta.',
        'phone.*' => 'El teléfono debe contener exactamente 10 dígitos.',
        'address2.*' => 'Las referencias del domicilio no pueden tener más de 200 caracteres.',
      ]);
      if($valid -> fails()){
        if($valid -> errors() -> has('address1')) throw new \Exception($valid -> errors() -> get('address1')[0]);
        if($valid -> errors() -> has('suburb')) throw new \Exception($valid -> errors() -> get('suburb')[0]);
        if($valid -> errors() -> has('zip_code')) throw new \Exception($valid -> errors() -> get('zip_code')[0]);
        if($valid -> errors() -> has('state')) throw new \Exception($valid -> errors() -> get('state')[0]);
        if($valid -> errors() -> has('city')) throw new \Exception($valid -> errors() -> get('city')[0]);
        if($valid -> errors() -> has('country')) throw new \Exception($valid -> errors() -> get('country')[0]);
        if($valid -> errors() -> has('fullname')) throw new \Exception($valid -> errors() -> get('fullname')[0]);
        if($valid -> errors() -> has('email')) throw new \Exception($valid -> errors() -> get('email')[0]);
        if($valid -> errors() -> has('phone')) throw new \Exception($valid -> errors() -> get('phone')[0]);
        if($valid -> errors() -> has('address2')) throw new \Exception($valid -> errors() -> get('address2')[0]);
      }
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}