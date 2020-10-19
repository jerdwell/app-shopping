<?php namespace Loftonti\Erso\Models;

use Model;
use Loftonti\Erso\Models\Products;
use Illuminate\Support\Str;

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
    public $table = 'loftonti_erso_cars';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    /**
     * events
     */
    public function beforeSave()
    {
        $this -> car_slug = Str::slug($this -> car_name);
    }

    /**
     * Scopes
     */
    public function scopeGetCarModels($query, $car)
    {
        $models = $query -> where('car_slug', 'like', "%{$car}%") -> get();
        $filter = [];
        foreach ($models as $key) {
            array_push($filter, $key -> id);
        }
        return $products = Applications::whereIn('car_id', $filter) -> groupBy('shipowner_id');
    }

    /** Relations */
    public $hasMany = [
        'Product' => [ 'Loftonti\Erso\Models\Products', 'key' => 'id' ]
    ];
    
}
