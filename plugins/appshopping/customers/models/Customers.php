<?php namespace appshopping\Customers\Models;

use Illuminate\Support\Facades\Hash;
use Model;


/**
 * Model
 */
class Customers extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];
    protected $hidden = ['customer_password', 'customer_email_verified', 'updated_at', 'created_at', 'deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'appshopping_customers_customers';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'customer_name' => 'required|string|max:150',
        'customer_lastname' => 'required|string|max:150',
        'customer_phone' => 'required|string|max:80',
        'customer_password' => 'required|string|min:8|max:30',
        'customer_email' => 'required|email|unique:appshopping_customers_customers,customer_email'
    ];

    /** Relations */
    public $attachOne = [
        'customer_avatar' => 'System\Models\File'
    ];

    public $jsonable = [
        'customer_address'
    ];

    /** events */
    public function beforeSave()
    {
        $this -> customer_password = Hash::make($this -> customer_password);
    }
}
