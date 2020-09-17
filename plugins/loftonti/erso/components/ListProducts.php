<?php namespace Loftonti\Erso\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Validator;
use Loftonti\Erso\Models\Categories;
use Loftonti\Erso\Models\Products;

class ListProducts extends ComponentBase
{
    public $list, $limit, $category, $categories, $model, $shipowner, $year;

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
            'model' => [
                'title' => 'model',
                'description' => 'model to list products',
            ],
            'shipowner' => [
                'title' => 'shipowner',
                'description' => 'shipowner to list products',
            ],
            'year' => [
                'title' => 'year',
                'description' => 'year to list products',
            ],
        ];
    }

    public function onRun()
    {
        try {
            $this -> category = $this->property('category') ? $this->property('category') : null;
            $this -> model = $this->property('model') ? $this->property('model') : null;
            $this -> shipowner = $this->property('shipowner') ? $this->property('shipowner') : null;
            $this -> year = $this->property('year') ? $this->property('year') : null;
            $this -> limit = $this->property('limit') ? $this->property('limit') : 20;
            $this -> validData();
            $this -> list = $this -> getList();
        } catch (\Exception $th) {
            $this -> list = [];
        }
    }

    public function validData()
    {
        $valid = Validator::make(
            [
                $this->property('category') => 'category',
                $this->property('limit') => 'limit',
                $this->property('model') => 'model',
                $this->property('shipowner') => 'shipowner',
                $this->property('year') => 'year',
            ],
            [
                'category' => 'nullable|string|regex:/^[a-z0-9-]+$/',
                'limit' => 'nullable|numeric',
                'shipowner' => 'nullable|integer|exists:loftonti_erso_shipowners,id',
                'model' => 'nullable|integer|exists:loftonti_erso_models,id',
                'year' => 'nullable|integer',
            ]
        );
        if($valid -> fails()) throw new \Exception('Parámetros de búsqueda no válidos.');
    }

    public function getList()
    {
        if($this -> model == null || $this -> shipowner == null || $this -> year == null){
            $this -> categories = '';
            return Products::filterByCategory($this -> category)
                ->with([
                    'brand',
                    'category',
                    'shipowner',
                    'enterprise',
                    'car',
                    'erso_code'
                ])
                -> paginate($this -> limit);
        }else{
            $category = Categories::where('category_slug', $this -> category) -> first();
            return Products::filterCars( $this -> model, $this -> shipowner, 'category', $category -> id, 'year', $this -> year )
            -> paginate($this -> limit);
        }
    }

}
