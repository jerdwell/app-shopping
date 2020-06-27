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
            'AppProducts\FormWidgets\BrandSpecifications' => 'brandspecifications',
        ];
    }


    public function registerSettings()
    {
    }
}
