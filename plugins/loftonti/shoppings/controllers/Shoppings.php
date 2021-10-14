<?php namespace LoftonTi\Shoppings\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Shoppings extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController'    ];
    
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('LoftonTi.Shoppings', 'main-menu-item');
    }
}
