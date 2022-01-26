<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateShoppingrequest
{

  public function __invoke(Request $request)
  {
    try {
      $errors = [];
      if (!$request -> request -> has("type")) throw new \Exception("Es necesario especificar si será una cotización ó un pedido.");
      if (!$request -> request -> has("branch_id")) throw new \Exception("Es necesario especificar la sucursal donde se realizará la cotización/pedido.");
      if (!$request -> request -> has("items")) throw new \Exception("Los elementos para generar la cotización o pedido son requeridos.");
      if (!$request -> request -> has("shopping_contact")) throw new \Exception("La dirección de entrega es requerida cuando se realizará un pedido.");
      $valid = Validator::make($request -> all(), $this -> rules(), $this -> messages());
      if ($valid -> fails()) {
        foreach ($valid -> errors() -> all() as $error) {
          $errors[] = $error;
        }
      }
      if (count($errors) > 0) throw new \Exception(join(' - ', $errors));
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function rules(): array
  {
    return [
      'type' => 'required|string|' . Rule::in(['quotation', 'order']),
      'branch_id' => 'required|integer|exists:loftonti_erso_branches,id',
      'customer_id' => 'present|nullable|integer|exists:loftonti_users_customers,id',
      'notes' => 'present|nullable|string|min:5|max:250',
      "shopping_contact" => "required|array",
      "shopping_contact.address1" => "present|nullable|string|max:250",
      "shopping_contact.suburb" => "present|nullable|string|max:150",
      "shopping_contact.zip_code" => "present|nullable|digits:5",
      "shopping_contact.state" => "present|nullable|string|max:80",
      "shopping_contact.city" => "present|nullable|string|max:150",
      "shopping_contact.country" => "present|nullable|string|max:150",
      "shopping_contact.fullname" => "present|nullable|string|max:150",
      "shopping_contact.phone" => "present|nullable|min:10|max:25|regex:/^[0-9\/-]*$/",
      "shopping_contact.email" => "present|email",
      "shopping_contact.address2" => "present|null",
      "items" => "required|array|min:1",
      "items.*.id" => "required|integer|exists:loftonti_erso_products,id",
      "items.*.quantity" => "required|numeric|max:10",
    ];
  }

  private function messages(): array
  {
    return [
      'type.*' => 'El tipo de documento no es válido.',
      'branch_id.*' => 'Esta sucursal no existe.',
      'customer_id.*' => 'Este cliente no existe.',
      'notes.*' => 'Las observaciones deben contener entre 5 y 250 caracateres',
      'shopping_contact.address1.*' => 'La dirección no puede contener más de 200 caracteres.',
      'shopping_contact.suburb.*' => 'La colonia no puede contener más de 100 caracteres.',
      'shopping_contact.zip_code.*' => 'El código postal debe contener 5 dígitos exactamente.',
      'shopping_contact.state.*' => 'El estado debe contener un máximo de 200 caracteres.',
      'shopping_contact.city.*' => 'La ciudad debe contener un máximo de 200 caraceres',
      'shopping_contact.country.*' => 'El país debe contener un máximo de 200 caracteres.',
      'shopping_contact.fullname.*' => 'El nombre debe contener un máximo de 250 caracteres.',
      'shopping_contact.email.*' => 'El correo este elemento no contiene la estructura correcta.',
      'shopping_contact.phone.*' => 'El teléfono debe contener entre 10 y 25 dígitos.',
      'shopping_contact.address2.*' => 'Las referencias del domicilio no pueden tener más de 200 caracteres.',
    ];
  }

}