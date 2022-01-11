<?php

namespace LoftonTi\Apiv1\Services\Customers\Request;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait NewCustomerRequest
{

  /**
   * Valid genearl data and address data to create new customer
   * @method validNewCustomer
   * @return void
   */
  public function validNewCustomer(Request $request)
  {
    try {
      $valid = Validator::make(
        $request -> all(), 
        $this -> rules($request->all()),
        $this -> messages()
      );
      if($valid -> fails()){
        $errors = [];
        foreach ($valid -> errors() -> all() as $error) {
          $errors[] = $error;
        }
        throw new \Exception(join(',', $errors));
      }
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function rules(array $customer)
  {
    return [
      'email' => 'required|email|' . Rule::unique('loftonti_users_customers') -> ignore(isset($customer['id']) ? $customer['id'] : null, 'id'),
      'phone' => 'required|max:25|regex:/^[0-9\/-]*$/',
      'password' => 'sometimes|string|min:8|max:20',
      'full_name' => 'required|string|min:4|max:120',
      'status' => 'sometimes|' . Rule::in(['A', 'S', 'M']),
      'rfc' => 'sometimes|nullable|alpha_num|min:12|max:13|' . Rule::unique('loftonti_users_customers') -> ignore(isset($customer['id']) ? $customer['id'] : null, 'id'),
      'address' => 'required|array',
      'address.line1' => 'present|nullable|string|min:1|max:80',
      'address.line2' => 'present|nullable|string|min:1|max:15',
      'address.line3' => 'present|nullable|string|min:1|max:15',
      'address.suburb' => 'present|nullable|string|min:1|max:50',
      'address.zip_code' => 'present|nullable|digits:5',
      'address.city' => 'present|nullable|string|min:1|max:50',
      'address.state' => 'present|nullable|string|min:1|max:50',
      'address.country' => 'present|nullable|string|min:1|max:50',
      'address.localty' => 'present|nullable|string|min:1|max:50',
      'address.cross_site1' => 'present|nullable|string|min:1|max:40',
      'address.cross_site2' => 'present|nullable|string|min:1|max:40',
      'address.referency' => 'present|nullable|string|min:1|max:255',
    ];
  }

  private function messages()
  {
    return [
      'email.*' => 'El correo es un dato requerido, debe de ser válido y no puede estar registrado con anterioridad',
      'phone.*' => 'El teléfono es un dato requerido y no puede contener más de 25 dígitos',
      'password.*' => 'La contraseña es un dato requerido y debe contener entre 8 y 20 caracteres incuidas mayúsculas, minúsculas y números',
      'full_name.*' => 'El nombre es un dato requerido y debe contener entre 4 y 120 caracteres',
      'status.*' => 'El status solo puede estar dentro de las categorías establlecidas (Activo, Suspendido, Moroso)',
      'rfc.*' => 'El RFC solo puede contener números y letras y debe contener entre 12 y 13 caracteres y no debe de estar asignado a otro cliente',
      'address.line1.*' => 'La calle debe contener entre 1 y 80 caracteres',
      'address.line2.*' => 'El número interior debe contener entre 1 y 15 caracteres',
      'address.line3.*' => 'El número debe contener entre 1 y 15 caracteres',
      'address.suburb.*' => 'La colonia debe contener entre 1 y 50 caracteres',
      'address.zip_code.*' => 'El código postal deberá tener 5 dígitos',
      'address.city.*' => 'La delegación/municipio debe contener entre 1 y 50 caracateres',
      'address.state.*' => 'El estado debe contener entre 1 y 50 caracateres',
      'address.country.*' => 'El país debe contener entre 1 y 50 caracateres',
      'address.localty.*' => 'La localidad debe contener entre 1 y 50 caracateres',
      'address.cross_site1.*' => 'El cruzamiento 1 debe contener entre 1 y 40 caracateres',
      'address.cross_site2.*' => 'El cruzamiento 2 debe contener entre 1 y 40 caracateres',
      'address.referency.*' => 'La referencia debe contener entre 1 y 255 caracateres',
    ];
  }

}