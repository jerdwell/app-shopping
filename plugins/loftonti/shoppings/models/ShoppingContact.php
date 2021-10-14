<?php namespace LoftonTi\Shoppings\Models;

use Model;

/**
 * Model
 */
class ShoppingContact extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var array
     */
    public $fillable = [
        'shopping_id',
        'address1',
        'suburb',
        'zip_code',
        'city',
        'state',
        'country',
        'fullname',
        'email',
        'phone',
        'address2'
    ];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'loftonti_shoppings_shopping_contact';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var array
     */
    public $hasOne = [
        'shopping' => 'LoftonTi\Shoppings\Models\Shoppings'
    ];
}
