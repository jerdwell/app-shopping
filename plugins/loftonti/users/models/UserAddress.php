<?php namespace LoftonTi\Users\Models;

use Model;

/**
 * Model
 */
class UserAddress extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var array filable to fill all public vars
     */
    public $fillable = [
        "address1",
        "suburb",
        "zip_code",
        "state",
        "city",
        "country",
        "address2"
    ];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'loftonti_users_address';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * Relations
     */
    public $belongsTo = [
        'user' => [ 'LoftonTi\Users\Models\Users', 'key' => 'id', 'otherKey' => 'user_id' ]
    ];

}
