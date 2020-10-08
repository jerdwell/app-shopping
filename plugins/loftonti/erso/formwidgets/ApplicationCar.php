<?php namespace Loftonti\erso\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Illuminate\Support\Facades\Input;
use Loftonti\Erso\Models\CarsModels;

/**
 * ApplicationCar Form Widget
 */
class ApplicationCar extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = '_loftonti/erso_application_car';

    /**
     * @inheritDoc
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('applicationcar');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        $this->vars['car_name'] = $this -> getCar();
    }

    /**
     * get car
     */
    public function getCar()
    {
        if($this -> model -> car_id){
            $car = CarsModels::find($this -> model -> car_id);
            return $car -> car_name;
        }else{
            return false;
        }
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
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/applicationcar.css', '.loftonti/erso');
        $this->addJs('js/applicationcar.js', '.loftonti/erso');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
