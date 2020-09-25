<?php namespace Loftonti\erso\Components;

use Cms\Classes\ComponentBase;
use Loftonti\Erso\Models\Products;

class ProductDetail extends ComponentBase
{
    public $product;
    public function componentDetails()
    {
        return [
            'name'        => 'ProductDetail',
            'description' => 'Get product detail by slug'
        ];
    }

    public function defineProperties()
    {
        return [
            'id' => [
                'title' => 'id',
                'description' => 'id to get product',
                'type' => 'string',
                'validationPattern' => '^[0-9-]'
            ],
        ];
    }

    public function onRun()
    {
        try {
            $id = $this -> property('id'); 
            $product = Products::find($id);
            if(empty($product)) throw new \Exception(null);
            $product -> brand;
            $product -> category;
            $product -> shipowner;
            $product -> enterprise;
            $product -> car;
            $product -> erso_code;
            $this -> product = $product;
        } catch (\Throwable $th) {
            //throw $th;
            return [$th -> getMessage()];
        }
    }
}
