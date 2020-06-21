<?php namespace AppShopping\Orders\Models;

use Illuminate\Support\Facades\DB;
use Model;

/**
 * Model
 */
class Orders extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'appshopping_orders_orders';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /** events */

    public function beforeSave()
    {
        DB::table('appshopping_orders_orders_items')
            -> where('order_id', $this -> id)
            -> delete();
    }

    
    /** Relations */
    public $belongsToMany = [
        'products' => [
            'AppProducts\Products\Models\Products',
            'table' => 'appshopping_orders_orders_items',
            'key'      => 'order_id',
            'otherKey' => 'product_id',
            'pivot' => ['quantity'],
        ]
    ];

}
