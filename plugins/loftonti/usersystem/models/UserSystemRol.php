<?php namespace LoftonTi\Usersystem\Models;

use Model;
use Illuminate\Support\Str;

/**
 * Model
 */
class UserSystemRol extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var array
     */
    public $fillable = [
        'rol_name',
        'description',
        'slug',
    ];

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'loftonti_usersystem_roles';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * Event before create a record
     * @method
     */
    public function beforeCreate()
    {
        $this -> slug = Str::slug($this -> rol_name);
        $exists = $this -> where('slug', $this -> slug)
            -> first();
        if(!empty($exists)) throw new \Exception("No se puede crear este rol ya que se encuentra asignado.");
    }
    
    /**
     * Event before update a record
     * @method
     */
    public function beforeUpdate()
    {
        $slug = Str::slug($this -> rol_name);
        if($slug != $this -> slug) {
            $exists = $this -> where('slug', $slug)
                -> first();
            if(!empty($exists)) throw new \Exception("Este rol ya se encuentra registrado");
        }
        $this -> slug = $slug;
        
    }

    /**
     * @var array
     */
    public $belongsToMany = [
        'modules' => [
            'LoftonTi\Usersystem\Models\UserSystemModule',
            'table' => 'loftonti_usersystem_rol_module_permissions',
            'key' => 'rol_id',
            'otherKey' => 'module_id',
            'pivot' => [
                'create',
                'read',
                'update',
                'delete',
            ]
        ]
    ];

}
