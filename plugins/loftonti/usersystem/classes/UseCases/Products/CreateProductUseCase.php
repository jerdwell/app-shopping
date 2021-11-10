<?php

namespace LoftonTI\Usersystem\Classes\UseCases\Products;

use Illuminate\Support\Facades\DB;
use Loftonti\Erso\Models\Products;

/**
 * Create product
 * @class
 */
class CreateProductUseCase
{

  /**
   * @var object
   */
  private $repository;

  /**
   * @var string
   */
  private $erso_code, $provider_code, $product_name, $public_price, $customer_price, $product_cover;
  
  /**
   * @var int
   */
  private $category_id, $brand_id;

  /**
   * @var array
   */
  private $applications;
  

  /**
   * 
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
  public function __construct($erso_code, $provider_code, $product_name, $category_id, $brand_id, $public_price, $customer_price, $product_cover, $applications) {
    $this -> erso_code = strtoupper($erso_code);
    $this -> provider_code = strtoupper($provider_code);
    $this -> product_name = strtoupper($product_name);
    $this -> category_id = $category_id;
    $this -> brand_id = $brand_id;
    $this -> public_price = $public_price;
    $this -> customer_price = $customer_price;
    $this -> product_cover = strtoupper($product_cover);
    $this -> applications = $applications;
    $this -> validExistProduct();
    $this -> repository = new Products();
  }

  public function __invoke():object
  {
    try {
      $product = [
        "erso_code" => $this -> erso_code,
        "provider_code" => $this -> provider_code,
        "product_name" => $this -> product_name,
        "category_id" => $this -> category_id,
        "brand_id" => $this -> brand_id,
        "public_price" => $this -> public_price,
        "customer_price" => $this -> customer_price,
        "product_cover" => $this -> product_cover . '.jpg'
      ];
      $p = DB::transaction(function() use($product) {
        $p = $this -> repository -> create($product);
        $this -> attachApplications($p);
        return $p;
      });
      return $p;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * @method attachApplications
   * @param object $product 
   */
  private function attachApplications(object $product):void
  {
    try {
      foreach ($this -> applications as $application) {
        $product -> applications() -> create([
          'car_id' => $application['car_id'],
          'shipowner_id' => $application['shipowner_id'],
          'year' => $application['year'],
          'note' => $application['note']
        ]);
      }
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function validExistProduct():void
  {
    try {
      
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}