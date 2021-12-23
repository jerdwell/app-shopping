<?php namespace LoftonTi\Users\Models;

use Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

/**
 * Model
 */
class Users extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

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
