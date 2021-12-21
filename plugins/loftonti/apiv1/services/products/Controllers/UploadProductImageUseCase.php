<?php

namespace LoftonTi\Apiv1\Services\Products\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadProductImageUseCase
{

  public function __invoke(Request $request)
  {
    try {
      $image = $request -> file('product-image');
      if(!$image) throw new \Exception("No existe un archivo para cargar");
      if(!in_array($image -> getMimeType(), ['image/png', 'image/jpg', 'image/jpeg'])) throw new \Exception("El tipo de imagen solo puede ser jpeg, jpg o png");
      if($image -> getSize() > 2000000) throw new \Exception("la imágen no debe exceder los 2MB.");
      Storage::putFileAs('media/products', $request -> file('product-image'), $request -> erso_code . '.jpg');
      return response() -> json([
        'message' => 'Imágen subida exitosamente.'
      ], 201);
    } catch (\Throwable $th) {
      return response() 
        -> json([
          'error' => $th -> getMessage()
        ], 403);
    }
  }

}