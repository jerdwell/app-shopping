<?php namespace Loftonti\Erso\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Validator;
use Loftonti\Erso\Models\Categories;
use Loftonti\Erso\Models\Products;

class ListProducts extends ComponentBase
{
    public $list, $limit, $category, $categories;

    public function componentDetails()
    {
        return [
            'name'        => 'ListProducts',
            'description' => 'Listado de productos para la sección general'
        ];
    }

    public function defineProperties()
    {
        return [
            'category' => [
                'title' => 'category',
                'description' => 'category to list products',
                'type' => 'string',
                'validationPattern' => '^[a-z0-9-]+$'
            ],
            'limit' => [
                'title' => 'category',
                'description' => 'category to list products',
                'type' => 'string',
                'validationPattern' => '[0-9]'
            ]
        ];
    }

    public function onRun()
    {
        $this -> category = $this->property('category') ? $this->property('category') : null;
        $this -> limit = $this->property('limit') ? $this->property('limit') : 20;
        $valid = Validator::make(
            [
                $this->property('category') => 'category',
                $this->property('limit') => 'limit'
            ],
            [
                'category' => 'nullable|string|regex:/^[a-z0-9-]+$/',
                'limit' => 'nullable|numeric'
            ]
        );
        if($valid -> fails()) return response($valid -> errors(), 404);
        $products = Products::filterByCategory($this -> category)
            ->with([
                'brand',
                'category',
                'shipowner',
                'enterprise',
                'car',
                'erso_code'
            ])
            -> paginate($this -> limit);
        $this -> categories = Categories::all();
        $this -> list = $products;
    }
}
