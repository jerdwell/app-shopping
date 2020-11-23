<?php namespace Loftonti\Erso\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Loftonti\Erso\Models\Branches;
use Loftonti\Erso\Models\Brands;
use Loftonti\Erso\Models\CarsModels;
use Loftonti\Erso\Models\Categories;
use Loftonti\Erso\Models\Products;
use Loftonti\Erso\Models\Shipowners;

class ListProducts extends ComponentBase
{
    public
        $list,
        $limit,
        $category,
        $categories,
        $model,
        $shipowner,
        $year,
        $model_selected,
        $branches,
        $branch,
        $brands,
        $brand,
        $brand_id,
        $shipowner_selected;

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
            'branch' => [
                'title' => 'branch',
                'description' => 'ERSO branch to get stock',
                'type' => 'string',
                'validationPattern' => '^[a-z0-9-]+$'
            ],
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
            'brand' => [
                'title' => 'brand',
                'description' => 'brand to list products',
            ],
        ];
    }

    public function onRun()
    {
        try {
            $this -> branch = $this->property('branch') ? $this->property('branch') : null;
            $this -> category = $this->property('category') ? $this->property('category') : null;
            if($this -> branch == null || $this -> category == null) return;
            $this -> model = $this->property('model') ? $this->property('model') : null;
            $this -> shipowner = $this->property('shipowner') ? $this->property('shipowner') : null;
            $this -> year = $this->property('year') ? intval($this->property('year')) : null;
            $this -> limit = $this->property('limit') ? $this->property('limit') : 20;
            $brand = $this->property('brand') ? Brands::where('brand_slug', $this->property('brand')) -> first() : null;
            $this -> brand = $brand ? $brand -> brand_name : null;
            $this -> brand_id = $brand ? $brand -> id : null;
            $this -> validBranch();
            $this -> branches = Branches::get();
            $this -> validData();
            $products = $this -> getList();
            $this -> list = $products  -> paginate($this -> limit);
            $this -> brands = $products -> groupBy('brand_id') -> without(['branches', 'applications', 'category']) -> get();
            $this -> categories = Categories::orderBy('category_name') -> get() -> makeHidden(['deleted_at', 'id', 'category_cover']);
            $shipowner = $this -> shipowner ? Shipowners::find($this -> shipowner) : false;
            $model = $this -> model ? CarsModels::find($this -> model) : false;
            $this -> model_selected = $this -> shipowner && $this -> model ? $model -> car_name : false;
            $this -> shipowner_selected = $shipowner ? $shipowner -> shipowner_name : false;
        } catch (\Exception $th) {
            // return [$th -> getMessage()];
            return Redirect::to('/productos');
        }
    }

    public function validData()
    {
        $valid = Validator::make(
            [
                $this->property('branch') => 'branch',
                $this->property('category') => 'category',
                $this->property('limit') => 'limit',
                $this->property('model') => 'model',
                $this->property('shipowner') => 'shipowner',
                $this-> year => 'year',
            ],
            [
                'branch' => 'nullable|string|exists:loftonti_erso_branches,slug',
                'category' => 'nullable|string|regex:/^[a-z0-9-]+$/',
                'limit' => 'nullable|numeric',
                'shipowner' => 'nullable|integer|exists:loftonti_erso_shipowners,id',
                'model' => 'nullable|integer|exists:loftonti_erso_models,id',
            ]
        );
        if($valid -> fails()) throw new \Exception('Parámetros de búsqueda no válidos.');
        if($this -> year && $this -> year <= 0) throw new \Exception('Parámetros de búsqueda no válidos.');
    }

    public function validBranch()
    {
        $branch = Branches::where('slug', $this -> property('branch')) -> first();
        if(empty($branch)) throw new \Exception("Esta sucursal no existe");
    }

    public function getList()
    {
        $branch = $this -> property('branch');
        if($this -> shipowner == null){
            return Products::filterByCategory($this -> category, $branch)
                ->orderBy('product_name')
                ->with([
                    'brand',
                    'category',
                    'applications',
                    'applications.car',
                    'applications.shipowner',
                    'branches' => function($q) use($branch) {
                        $q -> where('loftonti_erso_branches.slug', $branch)
                        ->select('id', 'slug');
                    }
                ]);
        }else{
            $category = Categories::where('category_slug', $this -> category) -> first();
            $filters = [];
            if($this -> year) $filters['year'] = $this -> year;
            if($category -> id) $filters['category'] = $category -> id;
            if($this -> brand_id) $filters['brand'] = $this -> brand_id;
            if($this -> year != null){
                return Products::filterCars($branch, $this -> model, $this -> shipowner, $filters);
            }else{ 
                return Products::filterCars($branch, $this -> model, $this -> shipowner, $filters);
            }
        }
    }

}
