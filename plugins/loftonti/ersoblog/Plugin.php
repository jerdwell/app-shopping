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
            'LoftonTi\ErsoBlog\Components\ListBlogsHome' => 'ListBlogsHome',
        ];
    }

    public function registerSettings()
    {
    }
}
