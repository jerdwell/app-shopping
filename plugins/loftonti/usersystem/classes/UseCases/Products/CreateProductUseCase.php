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
   * @var array
   */
  private $items, $errors = [];

  /**
   * @var object
   */
  private $repository;
  
  /**
   * @var int
   */
  private $assertions = 0, $branch_id;
  
  /**
   * @param array $products contain all products to create with applications
   * @param int $branch_id branch to attach products
   */
  public function __construct($products, $branch_id) {
    $this -> branch_id = $branch_id;
    $this -> setItems($products);
    $this -> repository = new Products();
  }
  
  public function __invoke()
  {
    try {
      // return $this -> items;
      $this -> createItems();
      return [
        "assertions" => $this -> assertions,
        "errors" => $this -> errors,
        "items" => $this -> items
      ];
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * Prepare data to create product
   * @method setItems
   * @param array $products
   * @return void
   */
  private function setItems($products)
  {
    try {
      foreach ($products as $product) {
        $prices = $this -> setPrices($product);
        $this -> items[] = $this -> setProduct(
          $product['CVE_ART'],
          $product['CVES_ALTER'],
          $product['DESCR'],
          $product['category']['id'],
          $product['brand']['id'],
          $prices['public_price'],
          $prices['customer_price'],
          $product['CVE_IMAGEN'],
          $product['applications'],
          $product['EXIST'],
          $product['enterprise_id']
        );
      }
    } catch (\Throwable $th) {
      throw $th;
    }
  }

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
  public function setProduct($erso_code, $provider_code, $product_name, $category_id, $brand_id, $public_price, $customer_price, $product_cover, $applications, $EXIST, $enterprise_id):array
  {
    try {
      $erso_code = strtoupper($erso_code);
      $provider_code = strtoupper($provider_code);
      $product_name = strtoupper($product_name);
      $category_id = $category_id;
      $brand_id = $brand_id;
      $public_price = $public_price;
      $customer_price = $customer_price;
      $product_cover = strtoupper($product_cover);
      $applications = $applications;
      $product = [
        "erso_code" => $erso_code,
        "provider_code" => $provider_code,
        "product_name" => $product_name,
        "category_id" => $category_id,
        "brand_id" => $brand_id,
        "public_price" => $public_price,
        "customer_price" => $customer_price,
        "product_cover" => $erso_code . '.jpg',
        "applications" => $this -> setApplications($applications),
        "EXIST" => $EXIST,
        "enterprise_id" => $enterprise_id
      ];
      return $product;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * Set ptoduct prices [public_price, customer_price]
   * @method setPrices
   * @param Array $product
   * @return void
   */
  private function setPrices($product):array
  {
    try {
      $public_price = 0;
      $customer_price = 0;
      if(count($product['prices']) <= 0){
        $public_price = $product['ULT_COSTO'];
        $customer_price = $product['ULT_COSTO'];
      }else{
        $public_price = collect($product['prices']) -> firstWhere('CVE_PRECIO', '=', 1);
        $customer_price = collect($product['prices']) -> firstWhere('CVE_PRECIO', '=', 2);
        $public_price = $public_price ? $public_price['PRECIO'] : $product['ULT_COSTO'];
        $customer_price = $customer_price ? $customer_price['PRECIO'] : $product['ULT_COSTO'];
      }
      return [
        'public_price' => $public_price,
        'customer_price' => $customer_price
      ];
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * @method setApplications
   * @param Array $applications
   * @return array
   */
  private function setApplications(array $applications)
  {
    try {
      foreach($applications as $application) {
        $shipowners[] = $application['shipowner']['id'];
        $cars[] = $application['car']['id'];
        $product_applications[] = [
          'car_id' => $application['car']['id'],
          'shipowner_id' => $application['shipowner']['id'],
          'year' => $application['years']['from'] . '-' . $application['years']['to'],
          'note' => $application['notes']
        ];
      }
      return $product_applications;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * @method createItems
   * @return int $assertions number of items created successfully
   */
  public function createItems()
  {
    $i = 1;
    foreach ($this -> items as $item) {
      try {
        $this -> createProduct($item);
        $this -> assertions ++;
      } catch (\Throwable $th) {
        $this -> errors[] = [
          'line' => $i,
          'error' => $th -> getMessage()
        ];
      }
      $i ++;
    }
  }

  /**
   * Create product and attach applications
   * @method createProduct
   * @param object $product 
   */
  private function createProduct(array $product):void
  {
    DB::transaction(function() use ($product) {
      try {
        $p = $this -> repository -> create($product);
        $p -> branches() -> attach([
          $this -> branch_id => [
            'enterprise_id' => $product['enterprise_id'],
            'stock' => $product['EXIST'],
          ]
        ]);
        foreach ($product['applications'] as $application) {
          $p -> applications() -> create([
            'car_id' => $application['car_id'],
            'shipowner_id' => $application['shipowner_id'],
            'year' => $application['year'],
            'note' => $application['note']
          ]);
        }
      } catch (\Throwable $th) {
        throw new \Exception($th -> getMessage());
      }
    });
  }

}