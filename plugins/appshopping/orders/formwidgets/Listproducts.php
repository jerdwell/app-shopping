<?php namespace AppShopping\Orders\FormWidgets;

use AppProducts\Products\Models\Products;
use AppShopping\Orders\Models\Orders;
use Backend\Classes\FormWidgetBase;

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
    $order = Orders::find($this -> model -> attributes['id']);
    $this -> vars['id'] = $this -> getId();
    $this -> vars['name'] = $this -> getFieldName();
    $this -> vars['value'] = $this -> getLoadValue();
    $this -> vars ['products'] = $order -> products;
    return $this -> makePartial('list-products');
  }

  public function loadAssets()
  {
    $this -> addCss('css/listproducts.css');
    $this -> addJs('js/listproducts.js');
  }

  public function onTest()
  {
    $products = Products::where('product_name', 'like', '%'. post('value') .'%')
      -> orWhere('product_sku', 'like', '%'. post('value') .'%') -> get();
    return $products;
  }

}