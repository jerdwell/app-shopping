<?php

namespace Loftonti\Apiv1\Services\Products\UseCase\SyncFile;

use LoftonTi\Apiv1\Services\Products\UseCase\GetAllProductsUseCase;

trait ParseProductsUseCase
{
  public function parseProducts()
  {
    $products = new GetAllProductsUseCase();
    $products = $products();
    foreach ($products as $product) {
      $this -> products[$product -> erso_code] = $product -> id;
    }
    unset($products);
  }
}