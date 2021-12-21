<?php

namespace LoftonTi\Apiv1\Services\Products\UseCase;

use LoftonTi\Apiv1\Services\Cars\Usecase\GetAllCarsUseCase;
use LoftonTi\Apiv1\Services\Products\UseCase\Traits\SetProductApplicationsTrait;
use LoftonTi\Apiv1\Services\Products\UseCase\Traits\SetProductPricesTrait;
use LoftonTi\Apiv1\Services\Shipowners\UseCase\GetAllShipownersUseCase;

/**
 * Set data to create product
 */
class SetDataProductUseCase
{
  use
    SetProductApplicationsTrait,
    SetProductPricesTrait;

  /**
   * @var null|string
   */
  private $erso_code,
  $provider_code,
  $product_name,
  $product_cover;
  /**
   * @var int
   */
  private $category_id, $brand_id, $enterprise_id;

  /**
   * @var array
   */
  private $prices;

  /**
   * @var array
   */
  private $applications, $cars, $shipowners;

  /**
   * @var float
   */
  private $stock;

  public function __construct()
  {
    $cars = new GetAllCarsUseCase();
    $shipowners = new GetAllShipownersUseCase();
    $this -> cars = collect($cars());
    $this -> shipowners = collect($shipowners());
  }

  /**
   * @param string $erso_code
   * @param null|string $provider_code
   * @param string $product_name
   * @param int $category_id
   * @param int $brand_id
   * @param string $public_price
   * @param string $customer_price
   * @param null|string $product_cover
   * @param array $applications
   */
  public function __invoke($data): array
  {
    $this -> enterprise_id = $data['enterprise_id'];
    $prices = $this ->setProductPrices($data['prices']);
    $product = [
      "enterprise_id" => $this -> enterprise_id,
      "erso_code" => $data['CVE_ART'],
      "provider_code" => $data['CVES_ALTER'],
      "product_name" => $data['DESCR'],
      "category_id" => $data['category']['id'],
      "brand_id" => $data['brand']['id'],
      "public_price" => $prices['public_price'],
      "customer_price" => $prices['customer_price'],
      "product_cover" => '/products/' . $data['CVE_ART'] . '.jpg',
      "stock" => $data['EXIST'],
      "applications" => $this -> setApplications($data['applications']),
    ];
    return $product;
  }

}