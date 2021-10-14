<?php
namespace LoftonTi\Shoppings\Classes\Validations;

use Loftonti\Erso\Models\Branches;

class ValidProductsQuotation
{

  /**
   * @var int
   */
  private $branch_id;

  /**
   * @var array
   */
  private $items, $errors;

  /**
   * @var object
   */
  private $products;

  public function __construct(array $items, $branch_id) {
    try {
      $this -> branch_id = $branch_id;
      $this->items = $items;
      $this -> parseItems();
      $this -> validProductsExists();
      $this -> validProductsExists();
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function parseItems()
  {
    try {
      $errors = [];
      foreach ($this -> items as $item) {
        try {
          $this -> validStructure($item);
        } catch (\Throwable $th) {
          array_push($errors, $th -> getMessage());
        }
      }
      if(count($errors) > 0) throw new \Exception(join('; ', $errors));
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function validStructure($item)
  {
    try {
      if(!$item['id']) throw new \Exception("Hace falta el elemento id del producto {$item['product_name']}.");
      if(!$item['quantity']) throw new \Exception("La cantidad del producto {$item['product_name']} es requerida.");
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  private function validProductsExists()
  {
    try {
      $ids = collect($this -> items) -> implode('id', ',');
      $ids = explode(',', $ids);
      $products = Branches::find($this -> branch_id)
        -> with(['products' => function($q) use($ids){
          $q -> whereIn('id', $ids)
            -> where('product_status', true)
            -> with(['brand']);
        }])
        -> first();
      $products = $products -> products;
      if(!$products || empty($products) || count($products) != count($ids)) throw new \Exception("Lo sentimos, alguno de los productos que intentas comprar ya no se encuentra disponible en esta sucursal.");
      $this -> products = $products;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  public function getProducts(): object
  {
    return $this -> products;
  }

}