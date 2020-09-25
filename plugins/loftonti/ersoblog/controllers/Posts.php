<?php namespace LoftonTi\ErsoBlog\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Posts extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\relationController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('LoftonTi.ErsoBlog', 'main-menu-item');
    }
    public function formExtendModel($model)
    {
        $this->initRelation($model);
    }
    
}