<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListShoppingsRequest
{

  public function __invoke(Request $request)
  {
    try {
      $errors = [];
      $valid = Validator($request -> all(), $this -> rules(), $this -> messages());
      if ($valid -> fails()) {
        foreach ($valid -> errors() -> all() as $error) {
          $errors[] = $error;
        }
      }
      if (count($errors) > 0) throw new \Exception(join(',', $errors));
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function rules():array
  {
    return [
      'order' => 'required|string|' . Rule::in(['asc', 'desc']),
      'begin' => 'required|date|before:' . now() -> format('d-m-Y'),
      'end' => 'required|date',
      'branch_id' => 'present|nullable|integer|exists:loftonti_erso_branches,id',
      'customer_id' => 'present|nullable|integer|exists:loftonti_users_customers,id',
      'limit' => 'required|integer|' . Rule::in([50, 100, 500, 1000])
    ];
  }

  private function messages():array
  {
    return [
      'order.*' => 'El órden de los pedidos no está dentro de los parámetros adminitdos.',
      'begin.*' => 'La fecha de inicio no puede ser mayor al día actual.',
      'end.*' => 'La fecha final no puede ser menor a la fecha actual.',
      'branch_id.*' => 'Esta sucursal no existe.',
      'customer_id.*' => 'Este cliente no existe.',
      'limit.*' => 'El límite seleccionado no es un dato válido'
    ];
  }

}