<?php

namespace LoftonTi\Apiv1\Services\Customers\Request;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateManyCustmersRequest
{

  public function __invoke(Request $request)
  {
    try {
      $valid = Validator::make($request -> all(), $this -> rules(), $this -> messages());
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

  public function rules()
  {
    return [
      'items' => 'required|array|min:1',
      'items.*.email' => 'required|email',
      'items.*.phone' => 'required|max:25|regex:/^[0-9\/-]*$/',
      'items.*.password' => 'sometimes|string|min:8|max:20',
      'items.*.full_name' => 'required|string|min:4|max:120',
      'items.*.status' => 'sometimes|' . Rule::in(['A', 'S', 'M']),
      'items.*.rfc' => 'sometimes|nullable|alpha_num|min:12|max:13',
      'items.*.address' => 'required|array',
      'items.*.address.line1' => 'present|nullable|string|min:1|max:80',
      'items.*.address.line2' => 'present|nullable|string|min:1|max:15',
      'items.*.address.line3' => 'present|nullable|string|min:1|max:15',
      'items.*.address.suburb' => 'present|nullable|string|min:1|max:50',
      'items.*.address.zip_code' => 'present|nullable|digits:5',
      'items.*.address.city' => 'present|nullable|string|min:1|max:50',
      'items.*.address.state' => 'present|nullable|string|min:1|max:50',
      'items.*.address.country' => 'present|nullable|string|min:1|max:50',
      'items.*.address.localty' => 'present|nullable|string|min:1|max:50',
      'items.*.address.cross_site1' => 'present|nullable|string|min:1|max:40',
      'items.*.address.cross_site2' => 'present|nullable|string|min:1|max:40',
      'items.*.address.referency' => 'present|nullable|string|min:1|max:255',
    ];
  }
  
  public function messages()
  {
    return [
      'items.*.email.*' => 'El correo es un dato requerido, debe de ser válido y no puede estar registrado con anterioridad',
      'items.*.phone.*' => 'El teléfono es un dato requerido y no puede contener más de 25 dígitos',
      'items.*.password.*' => 'La contraseña es un dato requerido y debe contener entre 8 y 20 caracteres incuidas mayúsculas, minúsculas y números',
      'items.*.full_name.*' => 'El nombre es un dato requerido y debe contener entre 4 y 120 caracteres',
      'items.*.status.*' => 'El status solo puede estar dentro de las categorías establlecidas (Activo, Suspendido, Moroso)',
      'items.*.rfc.*' => 'El RFC solo puede contener números y letras y debe contener entre 12 y 13 caracteres y no debe de estar asignado a otro cliente',
      'items.*.address.line1.*' => 'La calle debe contener entre 1 y 80 caracteres',
      'items.*.address.line2.*' => 'El número interior debe contener entre 1 y 15 caracteres',
      'items.*.address.line3.*' => 'El número debe contener entre 1 y 15 caracteres',
      'items.*.address.suburb.*' => 'La colonia debe contener entre 1 y 50 caracteres',
      'items.*.address.zip_code.*' => 'El código postal deberá tener 5 dígitos',
      'items.*.address.city.*' => 'La delegación/municipio debe contener entre 1 y 50 caracateres',
      'items.*.address.state.*' => 'El estado debe contener entre 1 y 50 caracateres',
      'items.*.address.country.*' => 'El país debe contener entre 1 y 50 caracateres',
      'items.*.address.localty.*' => 'La localidad debe contener entre 1 y 50 caracateres',
      'items.*.address.cross_site1.*' => 'El cruzamiento 1 debe contener entre 1 y 40 caracateres',
      'items.*.address.cross_site2.*' => 'El cruzamiento 2 debe contener entre 1 y 40 caracateres',
      'items.*.address.referency.*' => 'La referencia debe contener entre 1 y 255 caracateres',
    ];
  }

}