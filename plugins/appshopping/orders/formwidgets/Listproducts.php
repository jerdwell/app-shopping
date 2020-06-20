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
    if(isset($this -> model -> attributes['id'])){
      $order = Orders::find($this -> model -> attributes['id']);
      $this -> vars ['products'] = $order -> products;
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
  }

  public function onTest()
  {
    $products = Products::where('product_name', 'like', '%'. post('value') .'%')
      -> orWhere('product_sku', 'like', '%'. post('value') .'%') -> get();
    return $products;
  }

}