<?php namespace Loftonti\Erso;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'LoftonTi\Erso\Components\ListProducts' => 'ListProducts',
            'LoftonTi\Erso\Components\ContactBranch' => 'ContactBranch'
        ];
    }

    public function registerSettings()
    {
    }
}
