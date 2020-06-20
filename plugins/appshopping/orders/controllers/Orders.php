<?php namespace appShopping\Orders\Controllers;

use AppProducts\Products\Models\Products;
use Backend\Classes\Controller;
use BackendMenu;

class Orders extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('appShopping.Orders', 'main-menu-item');
    }

    public function onTests()
    {
        $input = post();
        $products = Products::where('product_name', 'like', '%' . $input['data'] . '%')->get();
        return ['products' => $products];
    }
}
