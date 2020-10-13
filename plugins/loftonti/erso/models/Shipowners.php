<?php namespace Loftonti\Erso\Models;

use Model;
use Illuminate\Support\Str;
use Loftonti\Erso\Models\Applications;

/**
 * Model
 */
class Shipowners extends Model
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
     * Events
     */
    public function beforeSave()
    {
        $this -> shipowner_slug = Str::slug($this -> shipowner_name);
    }

    /** Scopes **/

    public function scopeGetCarShipowner($query, $branch, $car)
    {
        $branch = Branches::where('slug',$branch)->first();
        $models = $query -> where('shipowner_name', 'like', "%{$car}%")
        -> get();
        $filter = [];
        foreach ($models as $key) {
            array_push($filter, $key -> id);
        }
        $products = Applications::select('loftonti_erso_application.*')
            -> whereIn('loftonti_erso_application.shipowner_id', $filter)
            -> leftJoin('loftonti_erso_products','loftonti_erso_products.id','loftonti_erso_application.product_id')
            -> leftJoin('loftonti_erso_product_branch','loftonti_erso_product_branch.product_id','loftonti_erso_products.id')
            ->where('loftonti_erso_product_branch.branch_id', $branch -> id)
            -> with(['car','shipowner']);
        return $products;
    }

    /** Scopes **/


    /**
     * @var string The database table used by the model.
     */
    public $table = 'loftonti_erso_shipowners';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /** Relations */
    public $hasMany = [
        'Products' => [ 'Loftonti\Erso\Models\Products', 'key' => 'shipowner_id' ]
    ];

}
