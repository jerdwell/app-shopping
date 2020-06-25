<?php namespace appShopping\Orders\Controllers;

use AppProducts\Products\Models\Products;
use appshopping\Customers\Models\Customers;
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

    public function onSearchCustomer()
    {
        $data_customer = post('data_customer');
        $customers = Customers::select('id', 'customer_name', 'customer_lastname', 'customer_email')
        ->where('customer_name', 'like', '%' . $data_customer . '%')
        ->where('customer_email_verified', 1)
        ->where('deleted_at', null)
        ->orWhere('customer_lastname', 'like', '%' . $data_customer . '%')
        ->orWhere('customer_email', '%' . $data_customer . '%')
        ->get();
        return $customers;
    }

}
