<?php

namespace LoftonTi\Apiv1\Services\Customers\Request;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

trait ListCustomersRequest
{

  public function listCustomersRequests(Request $request)
  {
    try {
      $valid = Validator::make(
        $request -> all(),
        $this -> rules(),
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

  private function rules()
  {
    return [
      'per_page' => 'required|nullable|integer|' . Rule::in([100, 200, 500, 1000]),
      'order' => 'present|nullable|string|' . Rule::in(['asc', 'desc']),
      'order_by' => 'present|nullable|string|' . Rule::in(['full_name', 'rfc', 'id', 'phone', 'type']),
      'param' => 'present|nullable|string|min:3|max:100',
    ];
  }

  private function messages()
  {
    return [
      'per_page.*' => 'El paginado puede ser por 100, 200, 500 o 1000 resultados por página',
      'order.*' => 'El órden solo puede ser ascendente o descendente',
      'order_by.*' => 'Los campos por los que puedes filtrar el cliente es nombre, rfc, id, teléfono, o tipo',
      'param.*' => 'El parámetro de búsqueda debe de ser de tipo texto y contener entre 3 y 100 caracteres'
    ];
  }

}