<?php namespace Loftonti\Erso\Models;

use Model;
use Loftonti\Erso\Models\Products;

/**
 * Model
 */
class CarsModels extends Model
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
    public $table = 'loftonti_erso_models';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * Scopes
     */
    public function scopeGetCarModels($query, $car)
    {
        $models = $query -> where('model_name', 'like', "%{$car}%") -> get();
        $filter = [];
        foreach ($models as $key) {
            array_push($filter, $key -> id);
        }
        $products = Products::selectRaw('loftonti_erso_models.id as model_id, loftonti_erso_models.model_name, loftonti_erso_products.shipowner_id, loftonti_erso_shipowners.shipowner_name')
        -> leftJoin('loftonti_erso_models','loftonti_erso_models.id','=','loftonti_erso_products.model_id')
        -> leftJoin('loftonti_erso_shipowners','loftonti_erso_shipowners.id','=','loftonti_erso_products.shipowner_id')
        -> whereIn('model_id',$filter);
        return $products;
    }

    /** Relations */
    public $hasMany = [
        'Product' => [ 'Loftonti\Erso\Models\Products', 'key' => 'id' ]
    ];
    
}
