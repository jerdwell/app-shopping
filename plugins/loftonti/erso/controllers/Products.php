<?php namespace Loftonti\Erso\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Loftonti\Erso\Models\CarsModels;
use Loftonti\Erso\Models\Shipowners;
use Illuminate\Support\Facades\Input;

class Products extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\ImportExportController',
        'Backend.Behaviors.RelationController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';
    public $importExportConfig = 'config_import_export.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Loftonti.Erso', 'main-menu-item');
    }

    /**
     * get car list
     */
    public function onSearchCar()
    {
        try {
            $data_search = Input::get('car');
            $cars = CarsModels::where('car_name', 'like', "%{$data_search}%") -> take(20) -> get();
            return $cars;
        } catch (\Throwable $th) {
            return response($th -> getMessage(), 403);
        }
    }

    /**
     * get list shipowners
     */
    public function onSearchShipowner()
    {
        try {
            $data_search = Input::get('shipowner');
            $shipowners = Shipowners::where('shipowner_name', 'like', "%{$data_search}%") -> take(20) -> get();
            return $shipowners;
        } catch (\Throwable $th) {
            return response($th -> getMessage(), 403);
        }
    }
}
