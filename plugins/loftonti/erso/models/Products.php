<?php namespace Loftonti\Erso\Models;

use Model;
use Illuminate\Support\Str;

/**
 * Model
 */
class Products extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


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

    public function scopeFilterCars($query, $model, $shipowner, $filter1, $value1, $filter2, $value2)
    {
        $query -> where('shipowner_id', $shipowner)
        ->where('model_id', $model)
        ->when($filter1, function($q) use($filter1, $value1){
            if($filter1 == 'year') return $q -> whereRaw("{$value1} between substring_index(product_year, '-', 1) AND substring_index(product_year, '-', -1)");
            if($filter1 == 'category') return $q -> where("category_id", $value1);
        })
        ->when($filter1 && $filter2, function($q) use ($filter1, $value1, $value2){
            if($filter1 == 'year') {
                $q -> whereRaw("{$value1} between substring_index(product_year, '-', 1) AND substring_index(product_year, '-', -1)")
                    -> where("category_id", $value2);
            }else{
                $q -> whereRaw("{$value2} between substring_index(product_year, '-', 1) AND substring_index(product_year, '-', -1)")
                    -> where("category_id", $value1);
            }
        })
        -> with([
            'shipowner',
            'brand',
            'car',
            'category',
        ]);
        return $query;
    }

    public function scopeFilterYear($query, $model, $shipowner, $filter1, $value1, $filter2, $value2)
    {
        $query -> select('product_year')
            ->groupBy('product_year')
            ->where('shipowner_id', $shipowner)
            ->where('model_id', $model)
            ->when($filter1, function($q) use($filter1, $value1){
                if($filter1 == 'year') return $q -> whereRaw("{$value1} between substring_index(product_year, '-', 1) AND substring_index(product_year, '-', -1)");
                if($filter1 == 'category') return $q -> where("category_id", $value1);
            })
            ->when($filter1 && $filter2, function($q) use ($filter1, $value1, $value2){
                if($filter1 == 'year') {
                    $q -> whereRaw("{$value1} between substring_index(product_year, '-', 1) AND substring_index(product_year, '-', -1)")
                        -> where("category_id", $value2);
                }else{
                    $q -> whereRaw("{$value2} between substring_index(product_year, '-', 1) AND substring_index(product_year, '-', -1)")
                        -> where("category_id", $value1);
                }
            });
        return $query;
    }

    public function scopeFilterCategories($query, $model, $shipowner, $filter1, $value1, $filter2, $value2)
    {
        $query -> select('category_id')
        ->where('shipowner_id', $shipowner)
        ->where('model_id', $model)
        ->when($filter1, function($q) use($filter1, $value1){
            if($filter1 == 'year') return $q -> whereRaw("{$value1} between substring_index(product_year, '-', 1) AND substring_index(product_year, '-', -1)");
            if($filter1 == 'category') return $q -> where("category_id", $value1);
        })
        ->when($filter1 && $filter2, function($q) use ($filter1, $value1, $value2){
            if($filter1 == 'year') {
                $q -> whereRaw("{$value1} between substring_index(product_year, '-', 1) AND substring_index(product_year, '-', -1)")
                    -> where("category_id", $value2);
            }else{
                $q -> whereRaw("{$value2} between substring_index(product_year, '-', 1) AND substring_index(product_year, '-', -1)")
                    -> where("category_id", $value1);
            }
        })
        ->groupBy('category_id');
        return $query;
    }

    /**
     * Scope for list products categories
     */
    public function scopeFilterByCategory($query, $category)
    {
        $query -> selectRaw('loftonti_erso_products.*')
            -> when($category != null, function($q) use($category){
                $q -> leftJoin('loftonti_erso_categories', 'loftonti_erso_categories.id','=', 'loftonti_erso_products.category_id')
                -> where('loftonti_erso_categories.category_name', $category);
            })
            ->orderBy('loftonti_erso_products.category_id');
        return $query;
    }

    /** Relations */

    public $belongsTo = [
        'brand' => [ 'Loftonti\Erso\Models\Brands' ],
        'category' => [ 'Loftonti\Erso\Models\Categories' ],
        'shipowner' => [ 'Loftonti\Erso\Models\Shipowners' ],
        'enterprise' => [ 'Loftonti\Erso\Models\Enterprises' ],
        'car' => [ 'Loftonti\Erso\Models\CarsModels', 'key' => 'model_id' ],
        'erso_code' => [ 'Loftonti\Erso\Models\ErsoCodes', 'key' => 'erso_code_id' ],
    ];

    public $belongsToMany = [
        'branches' => [
            'Loftonti\Erso\Models\Branches',
            'table' => 'loftonti_erso_product_branch',
            'key' => 'product_id',
            'otherKey' => 'branch_id',
            'pivot' => ['stock']
        ],
    ];

}
