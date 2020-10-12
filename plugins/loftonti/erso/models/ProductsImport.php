<?php namespace Loftonti\Erso\Models;

use Backend\Models\ImportModel;
use Illuminate\Support\Facades\DB;
use Loftonti\Erso\Models\{Categories, Products, Shipowners, Enterprises, Brands, CarsModels, ErsoCodes};
use Illuminate\Support\Str;
use PDO;

class ProductsImport extends ImportModel
{

  public $rules = [];
  
  /**
   * method to insert relations from produtcs with branches - enterprise - stock
   */
  public function importData($results, $sessionKey = null)
  {
    try {
      $items = [];
      foreach ($results as $row => $data) {
        if($data['product_id'] != ''){
          if($data['coacalco_enterprise'] != '' && $data['coacalco_branch'] != ''){
            array_push($items, ['product_id' => $data['product_id'], 'branch_id' => 3, 'enterprise_id' => $data['coacalco_enterprise'], 'stock' => 100]);
          }
          if($data['izcalli_enterprise'] != '' && $data['izcalli_branch'] != ''){
            array_push($items, ['product_id' => $data['product_id'], 'branch_id' => 1, 'enterprise_id' => $data['izcalli_enterprise'], 'stock' => 100]);
          }
          if($data['tlalnepantla_enterprise'] != '' && $data['tlalnepantla_branch'] != ''){
            array_push($items, ['product_id' => $data['product_id'], 'branch_id' => 2, 'enterprise_id' => $data['tlalnepantla_enterprise'], 'stock' => 100]);
          }
        }
        $this -> logCreated();
      }
      DB::connection()->getPdo()->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
      DB::table('loftonti_erso_product_branch') -> insert($items);
      DB::connection()->getPdo()->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    } catch (\Exception $ex) {
      $this->logError($row, $ex -> getMessage());
    }
  }


  /**
   * Importanción original de los productos
   */
  // public function importData($results, $sessionKey = null)
  // {
  //   try {
  //     $categories = Categories::all();
  //     $brands = Brands::all();
  //     $products = [];
  //     foreach ($results as $row => $data) {
  //       $categories = collect($categories);
  //       $brands = collect($brands);
        
  //       $category = $categories -> firstWhere('category_slug', Str::slug($data['category_name']));
  //       $brand = $brands -> firstWhere('brand_slug', Str::slug($data['brand_name']));
  //       $product = [
  //         'erso_code' => $data['erso_code'],
  //         'provider_code' => $data['provider_code'],
  //         'product_name' => $data['product_name'],
  //         'product_slug' => Str::slug($data['product_name']),
  //         'category_id' => $category -> id,
  //         'brand_id' => $brand -> id,
  //         'public_price' => $data['public_price'],
  //         'customer_price' => $data['customer_price'],
  //         'product_cover' => $data['product_cover'],
  //       ];
  //       array_push($products, $product);
  //       $this -> logCreated();
  //     }
  //     DB::connection()->getPdo() === (new Products)->getConnection()->getPdo(); // true
  //     DB::connection()->getPdo()->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
  //     Products::insert($products);
  //     DB::connection()->getPdo()->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  //   } catch (\Exception $ex) {
  //     $this->logError($row, $ex -> getMessage());
  //   }
  // }
  

}