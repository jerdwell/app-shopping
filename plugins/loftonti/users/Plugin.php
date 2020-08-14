<?php namespace LoftonTi\Users;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerFormWidgets()
    {
    }

    public function registerComponents()
    {
        return [
            'LoftonTi\Users\Components\UsersRegister' => 'UsersRegister'
        ];
    }

    public function registerSettings()
    {
    }
}
