<?php namespace LoftonTi\Components\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class SlideComponent extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('LoftonTi.Components', 'main-menu-item', 'side-menu-item');
    }
}
