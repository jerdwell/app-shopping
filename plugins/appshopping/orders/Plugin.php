<?php namespace AppShopping\Orders;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerFormWidgets()
    {
        return [
            'AppShopping\Orders\FormWidgets\Listproducts' => 'listproducts'
        ];
    }

    public function registerSettings()
    {
    }
}
