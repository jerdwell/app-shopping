<?php namespace Loftonti\Erso;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'LoftonTi\Erso\Components\ListProducts' => 'ListProducts',
            'LoftonTi\Erso\Components\ListCategories' => 'ListCategories',
            'LoftonTi\Erso\Components\ContactBranch' => 'ContactBranch',
            'LoftonTi\Erso\Components\ContactForm' => 'ContactForm',
            'LoftonTi\Erso\Components\ProductDetail' => 'ProductDetail',
            'LoftonTi\Erso\Components\SelectBranch' => 'SelectBranch',
        ];
    }

    public function registerFormWidgets(){
        return [
            'LoftonTi\Erso\FormWidgets\Recommended' => 'recommended',
            'LoftonTi\Erso\FormWidgets\ProductStock' => 'productstock'
        ];
    }


    public function registerSettings()
    {
    }
}
