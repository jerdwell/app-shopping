<?php namespace Loftonti\Erso\Models;

use Illuminate\Support\Facades\DB;
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
        $products = DB::table('loftonti_erso_product_branch')
            ->selectRaw('group_concat(loftonti_erso_product_branch.product_id) as id')
            ->where('loftonti_erso_product_branch.branch_id', $branch -> id)
            ->first();
        $products = explode(',', $products -> id);
        $applications = Applications::select('loftonti_erso_application.*')
            -> whereIn('loftonti_erso_application.shipowner_id', $filter)
            -> whereIn('loftonti_erso_application.product_id', $products)
            -> with(['car','shipowner']);
        return $applications;
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
