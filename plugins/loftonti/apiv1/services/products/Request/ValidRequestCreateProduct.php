<?php

namespace LoftonTi\Apiv1\Services\Products\Request;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Handler to valid each item of product to create
 */
class ValidRequestCreateProduct
{

  use ValidCreateErsoCodesRequest;

  public function valid(Request $request): void
  {
    $this -> validErsoCodes($request);
    $errors = [];
    $validator = Validator::make($request -> all(),[
      'items' => 'required|array|min:1',
      'items.*.DESCR' => 'required|string|max:50',
      'items.*.CVE_ART' => 'required|string|max:16',
      'items.*.CVES_ALTER' => 'present|string|max:16',
      'items.*.ULT_COSTO' => 'required|numeric',
      'items.*.COSTO_PROM' => 'present|numeric',
      'items.*.EXIST' => 'required|numeric',
      'items.*.brand' => 'required|array',
      'items.*.brand.id' => 'required|integer',
      'items.*.category' => 'required|array',
      'items.*.category.id' => 'required|integer',
      'items.*.applications' => 'required|array|min:1',
      'items.*.applications.*.car' => 'required|array',
      'items.*.applications.*.car.id' => 'required|integer',
      'items.*.applications.*.shipowner' => 'required|array',
      'items.*.applications.*.shipowner.id' => 'required|integer',
      'items.*.applications.*.years' => 'required|array',
      'items.*.applications.*.years.from' => 'required|numeric',
      'items.*.applications.*.years.to' => 'required|numeric',
      'items.*.prices' => 'required|array|size:2',
      'items.*.prices.*.CVE_PRECIO' => 'required|integer|' . Rule::in([1, 2]),
      'items.*.prices.*.PRECIO' => 'required|numeric',
    ], [
      'items.required' => 'No existe el campo items',
      'items.array' => 'Los productos a crear deben de ser de tipo array',
      'items.min' => 'La cantidad mínima de productos a crear es de 1',
      'items.*.DESCR.*' => 'Todos los elementos deben tener nombre de artículo y no debe contener más de 50 caracteres',
      'items.*.CVE_ART.*' => 'El código ERSO es un dato requerido y no debe contener más de 16 caracteres',
      'items.*.CVES_ALTER.*' => 'El código de proveedor no debe contener más de 16 caracteres',
      'items.*.ULT_COSTO.*' => 'El producto debe contener el campo de último costo y debe de ser de tipo numérico',
      'items.*.COSTO_PROM.*' => 'El campo último costo de de ser de tipo numérico',
      'items.*.EXIST.*' => 'El de existencias es requerido y debe de ser de tipo numérico',
      'items.*.brand.*' => 'Es necesario asignar una marca al producto',
      'items.*.brand.id.*' => 'Es necesario asignar una marca al producto',
      'items.*.category.*' => 'Es necesario asignar una categoría al producto',
      'items.*.category.id.*' => 'Es necesario asignar una categoría al producto',
      'items.*.applications.min' => 'Es necesario asignar almenos una aplicación al producto',
      'items.*.applications.*.car.*' => 'Es necesario asignar un auto a la aplicación del producto',
      'items.*.applications.*.shipowner.*' => 'Es necesario asignar una armadora a la aplicación del producto',
      'items.*.applications.*.years.*' => 'Es necesario asignar un rango de fechas para la aplicación',
      'items.*.prices.*' => 'Es necesario asignar el precio mínimo y público al producto',
    ]);
    if ($validator -> fails()) {
      if ($validator-> errors() -> has('items')) throw new \Exception($validator -> errors() -> get('items')[0]);
      if ($validator-> errors() -> all()) {
        $line = 1;
        foreach ($validator -> errors() -> all() as $error) {
          $errors[] = "Línea $line: " . $error;
          $line ++;
        }
        throw new \Exception(join(',', $errors));
      }
    }
  }

}