<?php namespace Loftonti\Erso\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Shipowners extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend.Behaviors.ImportExportController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $importExportConfig = 'config_import_export.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Loftonti.Erso', 'main-menu-item', 'side-menu-item3');
    }
}
