<?php

namespace LoftonTI\Usersystem\Classes\UseCases\Products;

use Illuminate\Support\Facades\DB;
use Loftonti\Erso\Models\Products;

class UpdateProductUseCase
{
  /**
   * @var int
   */
  private $branch_id, $enterprise_id;
  /**
   * @var object
   */
  private $repository, $entity;

  /**
   * @var array
   */
  private $product, $product_data;

  /**
   * @var string
   */
  private $erso_code;

  /**
   * @param string $erso_code code of product to be updated
   * @param array $product product data to update
   */
  public function __construct(string $erso_code, array $product, int $branch_id) {
    $this->branch_id = $branch_id;
    $this->enterprise_id = $product['enterprise_id'];
    $this->erso_code = $erso_code;
    $this->product = $product;
    $this -> repository = new Products;
    $this -> validProductExist();
  }
  
  public function __invoke()
  {
    try {
      $prices = $this -> setPrices($this -> product);
      $product_data = $this -> setProduct(
        $this -> product['CVE_ART'],
        $this -> product['CVES_ALTER'],
        $this -> product['DESCR'],
        $this -> product['category']['id'],
        $this -> product['brand']['id'],
        $prices['public_price'],
        $prices['customer_price'],
        $this -> product['CVE_IMAGEN'],
        $this -> product['applications'],
        $this -> product['EXIST'],
        $this -> product['enterprise_id'],
      );
      $this -> updateProduct($product_data);
      return $product_data;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * @method validProductExist
   */
  private function validProductExist():void
  {
    $product = $this -> repository -> where('erso_code', $this -> erso_code)
      -> first();
    if(!$product) throw new \Exception("El producto que intentas actualizar no existe.");
    $this -> entity = $product;
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
  private function setProduct($erso_code, $provider_code, $product_name, $category_id, $brand_id, $public_price, $customer_price, $product_cover, $applications, $EXIST, $enterprise_id):array
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
        "enterprise_id" => $enterprise_id,
        "EXIST" => $EXIST
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
          'year' => $application['year'],
          'note' => $application['note']
        ];
      }
      return $product_applications;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * @method updateProduct
   */
  private function updateProduct(array $product)
  {
    try {
      DB::transaction(function() use($product){
        $this -> entity -> update($product);
        $this -> entity -> branches() 
          -> where('id', $this -> branch_id)
          -> where('enterprise_id', $this -> enterprise_id)
          -> update(['stock' => $product['EXIST']]);
        $this -> entity -> applications() -> delete();
        foreach ($product['applications'] as $application) {
          $this -> entity -> applications() -> create([
            'car_id' => $application['car_id'],
            'shipowner_id' => $application['shipowner_id'],
            'year' => $application['year'],
            'note' => $application['note']
          ]);
        }
      });
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}