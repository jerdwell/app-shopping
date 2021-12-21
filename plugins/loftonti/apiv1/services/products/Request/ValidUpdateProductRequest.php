<?php

namespace LoftonTi\Apiv1\Services\Products\Request;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ValidUpdateProductRequest
{

  /**
   * @var object
   */
  private $request;

  public function __construct($request)
  {
    $this -> request = $request;
  }

  public function __invoke(): void
  {
    $valid = Validator::make($this -> request -> all(), $this -> rules(), $this -> messages() );
    if ($valid -> fails()) {
      $errors = [];
      foreach ($valid -> errors() -> all() as $error) {
        $errors[] = $error;
      }
      throw new \Exception(join($errors));
    }
  }
  
  private function rules(): array
  {
    return [
      'erso_code' => 'required|string|max:16',
      'product.CVE_ART' => 'required|string|max:16',
      'product.DESCR' => 'required|string|max:50',
      'product.CVES_ALTER' => 'present|nullable|string|max:16',
      'product.prices' => 'required|array|size:2',
      'product.prices.*.CVE_PRECIO' => 'required|integer|' . Rule::in([1, 2]),
      'product.prices.*.PRECIO' => 'required|numeric',
      'product.enterprise_id' => 'required|integer',
      'product.applications' => 'required|array|min:1',
      'product.applications.*.car' => 'required|array',
      'product.applications.*.car.id' => 'required|integer',
      'product.applications.*.shipowner' => 'required|array',
      'product.applications.*.shipowner.id' => 'required|integer',
      'product.applications.*.years' => 'required|array',
      'product.applications.*.years.from' => 'required|numeric',
      'product.applications.*.years.to' => 'required|numeric',
      'product.EXIST' => 'required|numeric',
      'product.brand' => 'required|array',
      'product.brand.id' => 'required|integer',
      'product.category' => 'required|array',
      'product.category.id' => 'required|integer',
    ];
  }

  private function messages(): array
  {
    return [
      'erso_code.*' => 'El código del producto es un dato requerido y no puede contener más de 16 caracteres',
      'product.CVE_ART.*' => 'La clave del artículo es un dato requerido y no puede contener más de 16 caracteres',
      'product.DESCR.*' => 'El nombre del producto es un dato requerido y no puede contener más de 50 caracteres',
      'product.CVES_ALTER.*' => 'La clave alterna del producto debe de ser de tipo texto y no puede superar los 50 caracteres',
      'product.prices.*' => 'Es necesario asignar los dos tipos de precios al producto, la clave de precio solo puede contener enteros entre 1 y 2 y el precio debe de ser de tipo numérico',
      'product.enterprise_id.*' => 'El id de la empresa es un dato requerido',
      'product.applications.*' => 'Todas las aplicaciones deben contener almenos un elemento y debe contener el año, el auto y la armadora como campos requeridos',
      'product.EXIST.*' => 'Las existencias deben de ser de tipo número',
      'product.brand.*' => 'Agrega una marca al producto, el id debe de ser de tipo numérico',
      'product.category.*' => 'Agrega una categoría al producto, el id debe de ser de tipo numérico',
    ];
  }

}