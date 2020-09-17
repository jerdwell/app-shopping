<?php namespace LoftonTi\ErsoBlog;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'LoftonTi\ErsoBlog\Components\MainBlog' => 'MainBlog',
        ];
    }

    public function registerSettings()
    {
    }
}
