<?php

namespace LoftonTi\Apiv1\Services\Products\UseCase;

use LoftonTi\Apiv1\Services\Cars\Usecase\GetAllCarsUseCase;
use Loftonti\Apiv1\Services\Products\Repositories\ProductEloquentRepository;
use LoftonTi\Apiv1\Services\Products\UseCase\Traits\SetProductApplicationsTrait;
use LoftonTi\Apiv1\Services\Products\UseCase\Traits\SetProductPricesTrait;
use LoftonTi\Apiv1\Services\Shipowners\UseCase\GetAllShipownersUseCase;

class UpdateProductUseCase
{
  use
    SetProductApplicationsTrait,
    SetProductPricesTrait;

  /**
   * @var int
   */
  private $branch_id;

  /**
   * @var array
   */
  private $product;

  /**
   * @var object
   */
  private 
    $repository,
    $cars,
    $shipowners;

  public function __construct($product) {
    $this -> branch_id = $product['branch_id'];
    $this -> product = $product;
    $this->repository = new ProductEloquentRepository;
    $cars = new GetAllCarsUseCase;
    $shipowners = new GetAllShipownersUseCase;
    $this -> cars = collect($cars());
    $this -> shipowners = collect($shipowners());
  }

  public function __invoke()
  {
    $prices = $this -> setProductPrices($this -> product['product']['prices']);
    $product = [
      'product_name' => $this -> product['product']['DESCR'],
      'provider_code' => $this -> product['product']['CVES_ALTER'],
      'public_price' => $prices['public_price'],
      'customer_price' => $prices['customer_price'],
      'category_id' => $this -> product['product']['category']['id'],
      'brand_id' => $this -> product['product']['brand']['id'],
      'stock' => $this -> product['product']['EXIST'],
      'enterprise_id' => $this -> product['product']['enterprise_id'],
      'branch_id' => $this -> branch_id,
      'applications' => $this -> setApplications($this -> product['product']['applications']),
    ];
    $this -> repository -> update($this -> product['erso_code'], $product);
    return $product;
  }

}