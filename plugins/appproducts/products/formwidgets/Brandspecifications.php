<?php namespace AppProducts\Products\FormWidgets;

use AppProducts\Products\Models\Brand;
use AppProducts\Products\Models\Products;
use Backend\Classes\FormWidgetBase;

/**
 * BrandSpecifications Form Widget
 */
class Brandspecifications extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'brandspecifications';


    public function widgetDetails()
    {
        return [
        'name' => 'brandspecifications',
        'description' => 'Especificaciones de las marcas'
        ];
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('brand-specifications');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this -> model -> product_brands;
        $this->vars['model'] = $this->model;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/brandspecifications.css', '.appproducts/products');
        $this->addJs('js/brandspecifications.js', '.appproducts/products');
    }

    /** AJAX Events */

    public function onSearchBrand()
    {
        $brand = Brand::all();
        return $brand;
    }

}
