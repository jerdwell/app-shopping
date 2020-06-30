<?php namespace AppProducts\Products;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerFormWidgets()
    {
        return [
            'AppProducts\Products\FormWidgets\BrandSpecifications' => 'brandspecifications',
            'AppProducts\Products\FormWidgets\StockManage' => 'stockmanage',
        ];
    }

    public function registerSettings()
    {
    }
    
    public function registerListColumnTypes()
    {
        return [
            'stock_test' => [$this, 'getTestColumn'],
        ];
    }

    public function getTestColumn($value, $column, $record)
    {
        if($value == false) return 'Sin dato';
        $template = '<ul>';
        foreach ($value as $brand) {
            $template .= '<li>';
            $template .= '<b>Código:</b> ' . $brand['brand_code'] . '</br>';
            $template .= '<b>Piezas en stock:</b> ' . $brand['stock_product'] . '</br>';
            $template .= '<b>Sucursal:</b> ' . $brand['branch_name'] . '</br>';
            $template .= '</li>';
        }
        $template .= '</ul>';
        return $template;
        return json_encode($value);
    }

}
