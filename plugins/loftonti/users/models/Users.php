<?php namespace LoftonTi\Users\Models;

use Model;
use LoftonTi\Apiv1\Services\Customers\Scopes\BeforeSave;

/**
 * Model
 */
class Users extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    use BeforeSave;

    protected $dates = ['deleted_at'];

    /**
     * @var array filable to fill all public vars
     */

    public $fillable = [
        "full_name",
        "email",
        "phone",
        "password",
        "type",
        "email_verified_at",
        "sk",
        "pk",
        "rfc",
        "status"
    ];

    /**
     * @var array set prootected fields
     */
    protected $hidden = [
        'password',
        'sk',
        'pk',
        'deleted_at'
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'loftonti_users_customers';

    public $rules = [];


    /**
     * Relations
     */

    public $hasOne = [
        'address' => [ 'LoftonTi\Users\Models\UserAddress', 'key' => 'user_id']
    ];

    public $hasMany = [
        'quotations' => [
            'LoftonTi\Quotations\Models\Quotations',
            'key' => 'id',
            'otherKey' => 'user_id'
        ]
    ];

}
