<?php namespace LoftonTi\Usersystem\Models;

use Illuminate\Support\Facades\Hash;
use Model;
use Illuminate\Support\Str;

/**
 * Model
 */
class UserSystem extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * @var array
     */
    public $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'sk',
        'pk',
        'rol_id',
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'loftonti_usersystem_user';

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * Event before create user
     * @method
     */
    public function beforeCreate()
    {
        $this -> password = Hash::make($this -> password);
        $this -> sk = Str::random(32);
        $this -> pk = Str::random(32);
        throw new \Exception($this -> password);
    }

    /**
     * @var array
     */
    public $belongsTo = [
        'rol' => [
            'LoftonTi\Usersystem\Models\UserSystemRol'
        ]
    ];

}
