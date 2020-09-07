<?php namespace Loftonti\Erso\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Illuminate\Support\Facades\Input;
use Loftonti\Erso\Models\Products;
use Illuminate\Support\Str;
use Loftonti\Erso\Models\ErsoCodes;

/**
 * recommended Form Widget
 */
class Recommended extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = '_loftonti/erso_recommended';

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
        return $this->makePartial('recommended');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/recommended.css', '.loftonti/erso');
        $this->addJs('js/recommended.js', '.loftonti/erso');
    }

    public function onSearchProducts()
    {
        try {
            $data = Input::get('data');
            $data = Str::slug($data);
            $codes = ErsoCodes::where('erso_code', 'like', "%$data%") -> with([ 'products', 'products.car' ]) -> take(15) -> get();
            return $codes;
        } catch (\Exception $th) {
            return response($th -> getMessage(), 403);
        }
    }

}
