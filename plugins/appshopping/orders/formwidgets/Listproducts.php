<?php namespace AppShopping\Orders\FormWidgets;

use AppProducts\Products\Models\Products;
use AppShopping\Orders\Models\Orders;
use Backend\Classes\FormWidgetBase;
use Illuminate\Support\Facades\Redirect;

class ListProducts extends FormWidgetBase
{

  /*
  * @var string a unique alias to identify this widget
  */

  protected $dafultalias = 'listproducts';

  public function widgetDetails()
  {
    return [
      'name' => 'listproducts',
      'description' => 'Lista de productos para cotizar'
    ];
  }

  public function render()
  {
    $this -> vars['total_order'] = 0;
    if(isset($this -> model -> attributes['id'])){
      $order = Orders::find($this -> model -> attributes['id']);
      $this -> vars ['products'] = $order -> products;
      foreach ($this -> vars['products'] as $product) {
        $this -> vars['total_order'] += $product -> pivot -> quantity * $product -> product_price;
      }
    }else{
      $this -> vars ['products'] = [];
    }
    $this -> vars['id'] = $this -> getId();
    $this -> vars['name'] = $this -> getFieldName();
    $this -> vars['value'] = $this -> getLoadValue();
    return $this -> makePartial('list-products');
  }

  public function loadAssets()
  {
    $this -> addCss('css/listproducts.css');
    $this -> addJs('js/listproducts.js');
    $this -> addJs('js/actions-list-products.js');
  }

  public function onFindProducts()
  {
    $products = Products::where('product_name', 'like', '%'. post('value') .'%')
      -> orWhere('product_sku', 'like', '%'. post('value') .'%') -> get();
    return $products;
  }

  public function onDetachProduct()
  {
    try {
      $order_id = post('order_id');
      $product_id = post('product_id');
      $Order = Orders::find($order_id) -> products() -> detach($product_id);
      return true;
    } catch (\Throwable $th) {
      return false;
    }
  }

}