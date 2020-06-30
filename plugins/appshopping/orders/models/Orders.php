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
    public $customer_data;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'appshopping_orders_orders';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
    
    public $jsonable = [
        'order_details'
    ];

    /** events */

    // public function beforeSave()
    // {
    //     DB::table('appshopping_orders_orders_items')
    //         -> where('order_id', $this -> id)
    //         -> delete();
    // }

    public function afterFetch()
    {
        $this -> customer_data = $this -> order_customer;
    }
    
    /** Relations */

    public $hasOne = [
        'order_customer' => [
            'appshopping\Customers\Models\Customers',
            'key' => 'id',
            'otherKey' => 'customer_id'
        ]
    ];

}
