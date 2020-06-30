<?php namespace AppShopping\Orders\FormWidgets;

use AppProducts\Products\Models\Products;
use AppShopping\Orders\Models\Orders;
use Backend\Classes\FormWidgetBase;

class ListProducts extends FormWidgetBase
{

  /*
  * @var string a unique alias to identify this widget
  */

  protected $defaultAlias = 'listproducts';

  public function widgetDetails()
  {
    return [
      'name' => 'listproducts',
      'description' => 'Lista de productos para cotizar'
    ];
  }

  public function render()
  {
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
      -> orWhere('product_stock','like', '%'. post('value') .'%')
      ->with('product_brands')
      -> get();
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

  public function onGetProduct()
  {
    $product = Products::find(post('product_id'));
    $product -> product_cover;
    return $product;
  }

}