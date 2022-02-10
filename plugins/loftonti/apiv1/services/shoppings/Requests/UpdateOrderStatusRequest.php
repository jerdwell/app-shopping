<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateOrderStatusRequest
{

  public function __invoke(Request $request): void
  {
    try {
      $errors = [];
      $valid = Validator::make($request -> all(), $this -> rules(), $this -> messages());
      if ($valid -> fails()){
        foreach ($valid -> errors() -> all() as $error) {
          $errors[] = $error;
        }
        throw new \Exception(join(', ', $errors));
      }
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function rules(): array
  {
    return [
      'id' => 'required|integer|exists:loftonti_shoppings_shopping,id',
      'status' => 'required|string|' . Rule::in(['standby', 'ready', 'shipped', 'cancelled']),
      'notes' => 'present|string|nullable|min:5|max:250',
      'invoice_motive' => 'present|string|nullable|' . Rule::in(['02', '03']) . '|required_if:status,cancelled'
    ];
  }

  private function messages(): array
  {
    return [
      'id.*' => 'Este pedido no existe en el sistema',
      'status.*' => 'El status que intentas asignar no está permitido',
      'notes.*' => 'Las observaciones deben contener entre 5 y 250 caracateres',
      'invoice_motive.*' => 'Captura el motivo de cancelación fiscal'
    ];
  }

}