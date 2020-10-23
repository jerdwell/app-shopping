<?php namespace Loftonti\Erso\Models;

use Model;
use Illuminate\Support\Str;
use Loftonti\Erso\Models\Applications;
use Loftonti\Erso\Models\Categories;

/**
 * Model
 */
class Products extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    public $fillable = [
        'erso_code',
        'provider_code',
        'product_name',
        'product_slug',
        'category_id',
        'brand_id',
        'public_price',
        'customer_price',
        'product_cover'
    ];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'loftonti_erso_products';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /** Events */

    public function beforeSave()
    {
        $this -> product_slug = Str::slug($this -> product_name);
    }

    /** Scopes */

    public function scopeFilterCars($query, $branch, $model, $shipowner, $filters)
    {
        try {
            $applications = Applications::selectRaw('group_concat(loftonti_erso_application.product_id) as ids')
                -> leftJoin('loftonti_erso_products', 'loftonti_erso_products.id','=','loftonti_erso_application.product_id')
                ->where('loftonti_erso_application.shipowner_id', $shipowner)
                ->when($model, function ($q) use($model)
                {
                    $q ->where('loftonti_erso_application.car_id', $model);
                })
                /**
                 * add year filter
                 */
                ->when(isset($filters['year']), function($q) use($filters){
                    $q -> whereRaw("{$filters['year']} between substring_index(year, '-', 1) AND substring_index(year, '-', -1)");
                })
                /**
                 * add category filter
                 */
                ->when(isset($filters['category']), function($q) use($filters){
                    $q -> where('loftonti_erso_products.category_id',$filters['category']);
                })
                /**
                 * add brand filter
                 */
                ->when(isset($filters['brand']), function($q) use($filters){
                    $q -> where('loftonti_erso_products.brand_id', $filters['brand']);
                })
                -> first();
            $ids = explode(',', $applications -> ids);
            $query -> select('loftonti_erso_products.*')
            -> whereIn('loftonti_erso_products.id', $ids)
            ->leftJoin('loftonti_erso_product_branch','loftonti_erso_product_branch.product_id','loftonti_erso_products.id')
            ->leftJoin('loftonti_erso_branches','loftonti_erso_branches.id','loftonti_erso_product_branch.branch_id')
            ->where('loftonti_erso_branches.slug',$branch)
            // ->orderBy('loftonti_erso_products.product_name','asc')
            -> orderBy('loftonti_erso_products.public_price','desc')
            -> with([
                'brand',
                'category',
                'branches',
                'branches',
                'applications',
                'applications.shipowner',
                'applications.car',
            ]);
            return $query;
        } catch (\Throwable $th) {
            return [$th -> getMessage()];
        }
    }

    public function scopeFilterCategories($query, $model, $shipowner, $filter1, $value1, $filter2, $value2, $branch)
    {
        $applications = Applications::select('product_id')
            -> where('shipowner_id', $shipowner)
            -> where('car_id', $model) -> get();
        $ids = [];
        foreach ($applications as $application) {
            array_push($ids, $application -> product_id);
        }
        $products = Products::select('category_id')
            ->whereIn('id', $ids)
            ->groupBy('category_id')
            ->get();
        $categories = [];
        foreach ($products as $product) {
            array_push($categories, $product -> category_id);
        }
        return Categories::whereIn('id', $categories);
    }

    /**
     * Scope for list products categories
     */
    public function scopeFilterByCategory($query, $category, $branch)
    {
        $query -> selectRaw('loftonti_erso_products.*')
            -> leftJoin('loftonti_erso_product_branch', 'loftonti_erso_product_branch.product_id','=', 'loftonti_erso_products.id')
            -> leftJoin('loftonti_erso_branches', 'loftonti_erso_branches.id','=', 'loftonti_erso_product_branch.branch_id')
            -> when($category != null, function($q) use($category, $branch){
                $q -> leftJoin('loftonti_erso_categories', 'loftonti_erso_categories.id','=', 'loftonti_erso_products.category_id')
                -> where('loftonti_erso_categories.category_name', $category);
            })
            -> where('loftonti_erso_branches.slug', $branch)
            ->orderBy('loftonti_erso_products.category_id');
        return $query;
    }

    /** Relations */

    public $belongsTo = [
        'brand' => [ 'Loftonti\Erso\Models\Brands' ],
        'category' => [ 'Loftonti\Erso\Models\Categories' ],
    ];

    public $hasMany = [
        'applications' => [
            'Loftonti\Erso\Models\Applications',
            'key' => 'product_id',
            'otherKey' => 'id',
        ],
    ];

    public $belongsToMany = [
        'branches' => [
            'Loftonti\Erso\Models\Branches',
            'table' => 'loftonti_erso_product_branch',
            'key' => 'product_id',
            'otherKey' => 'branch_id',
            'pivot' => ['stock', 'enterprise_id']
        ],
    ];

}
