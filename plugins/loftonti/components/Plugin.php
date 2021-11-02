<?php namespace LoftonTi\Components;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'LoftonTi\Components\Components\SlideComponent' => 'SlideComponent'
        ];
    }

    public function registerSettings()
    {
    }
}
