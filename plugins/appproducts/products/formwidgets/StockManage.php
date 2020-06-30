<?php namespace AppProducts\Products\FormWidgets;

use AppProducts\Branches\Models\Branches;
use Backend\Classes\FormWidgetBase;
use Illuminate\Support\Facades\DB;

/**
 * StockManage Form Widget
 */
class StockManage extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'products_stock_manage';

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
        return $this->makePartial('stockmanage');
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
        $this->addCss('css/stockmanage.css', '.appproducts/products');
        $this->addJs('js/stockmanage.js', '.appproducts/products');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }

    
    /** Events */
    public function onSearchDataToAttach()
    {
        $product_id = post('product_id');
        $branches = Branches::select('id', 'branch_name') -> get();
        $details = DB::table('appproducts_products_brands_details') -> select('brand_code') -> where('product_id', $product_id) -> get();
        return [
            'branches' => $branches,
            'brands' => $details
        ];
    }

}
