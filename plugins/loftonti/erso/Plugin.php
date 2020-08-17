<?php namespace Loftonti\Erso;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'LoftonTi\Erso\Components\ListProducts' => 'ListProducts'
        ];
    }

    public function registerSettings()
    {
    }
}
