<?php namespace LoftonTi\ErsoBlog;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'LoftonTi\ErsoBlog\Components\MainBlog' => 'MainBlog',
            'LoftonTi\ErsoBlog\Components\BlogFilter' => 'BlogFilter',
            'LoftonTi\ErsoBlog\Components\BlogDetail' => 'BlogDetail',
        ];
    }

    public function registerSettings()
    {
    }
}
