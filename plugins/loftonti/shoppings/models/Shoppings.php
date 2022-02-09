<?php namespace LoftonTi\Shoppings\Models;

use Model;

/**
 * Model
 */
class Shoppings extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'loftonti_shoppings_shopping';
    
    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var array 
     */
    public $fillable = [
        'amount',
        'discount',
        'status',
        'shipping_cost',
        'branch_id',
        'user_id',
        'notes',
        'sold_out',
        'payment_method',
        'type_billing',
        'billing_id'
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var array
     */
    public $hasOne = [
        'shopping_contact' => [
            'LoftonTi\Shoppings\Models\ShoppingContact',
            'key' => 'shopping_id'
        ],
    ];
    
    /**
     * @var array
     */
    public $belongsTo = [
        'user' => 'LoftonTi\Users\Models\Users',
        'branch' => 'Loftonti\Erso\Models\Branches'
    ];

    /**
     * @var array
     */
    public $belongsToMany = [
        'products' => [
            'Loftonti\Erso\Models\Products',
            'table' => 'loftonti_shoppings_shopping_products',
            'key' => 'shopping_id',
            'otherKey' => 'product_id',
            'pivot' => ['current_price', 'discount', 'quantity']
        ]
    ];
}
