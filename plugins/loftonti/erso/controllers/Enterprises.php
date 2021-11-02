<?php namespace Loftonti\Erso\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Enterprises extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Loftonti.Erso', 'main-menu-item', 'side-menu-item6');
    }
}
