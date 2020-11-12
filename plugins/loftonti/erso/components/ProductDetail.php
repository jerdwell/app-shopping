<?php namespace Loftonti\erso\Components;

use Cms\Classes\ComponentBase;
use Loftonti\Erso\Models\Products;
use Illuminate\Database\Eloquent\Builder;

class ProductDetail extends ComponentBase
{
    public $product, $related;
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
            'branch' => [
                'title' => 'branch',
                'description' => 'branch to get product',
                'type' => 'string',
                'validationPattern' => '^[0-9-]'
            ],
        ];
    }

    public function onRun()
    {
        try {
            $branch = $this -> property('branch');
            $id = $this -> property('id'); 
            $product = Products::where('id', $id)
                -> whereHas('branches', function(Builder $q) use($branch){
                    $q -> where('slug', $branch);
                })
                ->with([
                    'brand',
                    'branches',
                    'category',
                    'applications',
                    'applications.car',
                    'applications.shipowner',
                ])
                -> first();
            if(empty($product)) throw new \Exception('Este producto existe en esta sucursal');
            $this -> product = $product;
            if(count($product -> applications) > 0){
                $this -> related = Products::whereHas('applications', function(Builder $q) use($product){
                    $q -> where('shipowner_id', $product -> applications[0] -> shipowner_id)
                    ->where('car_id', $product -> applications[0] -> car_id);
                })
                -> whereHas('branches', function(Builder $q) use($branch){
                    $q -> where('slug', $branch);
                })
                 -> with([
                    'brand',
                    'category',
                    'applications',
                    'applications.car',
                    'applications.shipowner',
                    'branches' => function($q) use($branch) {
                        $q -> where('loftonti_erso_branches.slug', $branch)
                        ->select('id');
                    }
                ])
                 ->paginate(8);
            }
        } catch (\Throwable $th) {
            // return [$th -> getMessage()];
            return redirect('/productos');
        }
    }
}
