<?php namespace Loftonti\erso\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Loftonti\Erso\Models\Enterprises;

/**
 * ProductStock Form Widget
 */
class ProductStock extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = '_loftonti/erso_product_stock';

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
        return $this->makePartial('productstock');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
        $this->vars['enterprises'] = self::getEnterprises();
    }

    /**
     * Get list oof enterprises
     */
    private static function getEnterprises()
    {
        $enterprises = Enterprises::all();
        return $enterprises;
    }
    

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/productstock.css', '.loftonti/erso');
        $this->addJs('js/productstock.js', '.loftonti/erso');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
