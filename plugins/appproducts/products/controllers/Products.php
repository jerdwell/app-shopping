<?php namespace AppProducts\Products\Controllers;

use Backend\Classes\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use AppProducts\Products\Models\Products as ProductsModel;
use BackendMenu;

class Products extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend.Behaviors.RelationController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('AppProducts.Products', 'main-menu-item');
    }

    public function FindProducts($type, $val, $limit = null){
        $limit =  $limit !=  null ? $limit : 20;
        $valid = Validator::make(
            ['type' => $type],
            ['type' => Rule::in( ['car','brand','general'] )]
        );
        if($valid -> fails()) return response() -> json(['Error' => 'El recurso solicitado no está disponible'], 403);
    
        switch ($type) {
            case 'car':
                $products = ProductsModel::where('product_description', 'like', "%$val%")
                    ->with('product_cover')
                    ->with('product_brands_customer')
                    -> paginate($limit);
            break;
            case 'car':
                $products = ProductsModel::where('product_stock', 'like', "%$val%")
                    ->with('product_cover')
                    ->with('product_brands_customer')
                    -> paginate($limit);
                break;
            
            case 'general':
                $products = ProductsModel::where('product_stock', 'like', "%$val%")
                    -> orWhere('product_description', 'like', "%$val%")
                    -> orWhere('product_name', 'like', "%$val%")
                    ->with('product_cover')
                    ->with('product_brands_customer')
                    -> paginate($limit);
                break;
            
        }
    
        return $products;
    }

}
