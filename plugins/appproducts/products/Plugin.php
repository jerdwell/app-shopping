<?php namespace AppProducts\Products;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerFormWidgets()
    {
        return [
            'AppProducts\Products\FormWidgets\BrandSpecifications' => 'brandspecifications',
            'AppProducts\Products\FormWidgets\StockManage' => 'stockmanage',
        ];
    }


    public function registerSettings()
    {
    }
}
