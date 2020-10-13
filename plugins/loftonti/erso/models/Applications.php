<?php namespace Loftonti\Erso\Models;

use Model;

/**
 * Model
 */
class Applications extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    public $fillable = [
        'product_id',
        'car_id',
        'shipowner_id',
        'year',
        'note'
    ];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'loftonti_erso_application';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * scopes
     */

    public function scopeGetCarModels($query, $car)
    {
        try {
            $cars = CarsModels::where('car_name', 'like', "%{$car}%") -> get();
            $filter = [];
            foreach ($cars as $key) {
                array_push($filter, $key -> id);
            }
            $cars = Applications::whereIn('car_id', $filter);
            return $cars;
        } catch (\Throwable $th) {
            return $th -> getMessage();
        }
    }

    public function scopeFilterYear($query, $branch, $model, $shipowner, $filter1, $value1, $filter2, $value2)
    {
        [$filter1];
        $query -> select('year')
            ->where('shipowner_id', $shipowner)
            ->where('car_id', $model)
            ->groupBy('year')
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

            // -> leftJoin('loftonti_erso_product_branch', 'loftonti_erso_product_branch.product_id','=', 'loftonti_erso_products.id')
            // -> leftJoin('loftonti_erso_branches', 'loftonti_erso_branches.id','=', 'loftonti_erso_product_branch.branch_id')
            // -> where('loftonti_erso_branches.slug', $branch)
            // ->groupBy('year')
            // ->where('shipowner_id', $shipowner)
            // ->where('model_id', $model)
        
        
        return $query;


        $query -> select('year')
            -> leftJoin('loftonti_erso_product_branch', 'loftonti_erso_product_branch.product_id','=', 'loftonti_erso_products.id')
            -> leftJoin('loftonti_erso_branches', 'loftonti_erso_branches.id','=', 'loftonti_erso_product_branch.branch_id')
            -> where('loftonti_erso_branches.slug', $branch)
            ->groupBy('year')
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

    /**
     * @var array belongs to many to set relation many to many
     */

    public $hasOne = [
        'car' => [
            'Loftonti\Erso\Models\CarsModels',
            'key' => 'id',
            'otherKey' => 'car_id',
        ],
        'shipowner' => [
            'Loftonti\Erso\Models\Shipowners',
            'key' => 'id',
            'otherKey' => 'shipowner_id',
        ],
    ];

}
