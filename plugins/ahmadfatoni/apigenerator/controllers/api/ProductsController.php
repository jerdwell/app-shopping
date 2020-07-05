<?php namespace AhmadFatoni\ApiGenerator\Controllers\API;

use Cms\Classes\Controller;
use BackendMenu;

use Illuminate\Http\Request;
use AhmadFatoni\ApiGenerator\Helpers\Helpers;
use Illuminate\Support\Facades\Validator;
use AppProducts\Products\Models\Products;
use Illuminate\Validation\Rule;

class ProductsController extends Controller
{
	protected $Products;

    protected $helpers;

    public function __construct(Products $Products, Helpers $helpers)
    {
        parent::__construct();
        $this->Products    = $Products;
        $this->helpers          = $helpers;
    }


    /** Fin products */
    public function index($type, $val, $limit = null){
        $limit =  $limit !=  null ? $limit : 20;
        $valid = Validator::make(
            ['type' => $type],
            ['type' => Rule::in( ['car','brand','general']) ]
        );
        if($valid -> fails()) return response() -> json(['Error' => 'El recurso solicitado no está disponible'], 403);

        switch ($type) {
            case 'car':
                $products = $this -> Products
                    -> where('product_description', 'like', "%$val%")
                    ->with('product_cover') -> paginate($limit);
            break;
            case 'car':
                $products = $this -> Products
                    -> where('product_stock', 'like', "%$val%")
                    ->with('product_cover') -> paginate($limit);
                break;
            
            case 'general':
                $products = $this -> Products
                    -> where('product_stock', 'like', "%$val%")
                    -> orWhere('product_description', 'like', "%$val%")
                    -> orWhere('product_name', 'like', "%$val%")
                    ->with('product_cover') -> paginate($limit);
                break;
            
        }

        return $products;
    }

    public static function getAfterFilters() {return [];}
    public static function getBeforeFilters() {return [];}
    public static function getMiddleware() {return [];}
    public function callAction($method, $parameters=false) {
        return call_user_func_array(array($this, $method), $parameters);
    }
    
}