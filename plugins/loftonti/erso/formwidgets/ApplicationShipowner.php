<?php namespace Loftonti\erso\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Illuminate\Support\Facades\Input;
use Loftonti\Erso\Models\Shipowners;

/**
 * ApplicationShipowner Form Widget
 */
class ApplicationShipowner extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = '_loftonti/erso_application_shipowner';

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
        return $this->makePartial('applicationshipowner');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        $this->vars['shipowner'] = $this->getShipowner();
    }

    public function getShipowner()
    {
        if($this -> model -> shipowner_id){
            $shipowner = Shipowners::find($this -> model -> shipowner_id);
            return [
                'shipowner_name' => $shipowner -> shipowner_name,
                'shipowner_id' => $shipowner -> id,
            ];
        }else{
            return [
                'shipowner_name' => false,
                'shipowner_id' => false
            ];
        }
    }

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

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/applicationshipowner.css', '.loftonti/erso');
        $this->addJs('js/applicationshipowner.js', '.loftonti/erso');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
