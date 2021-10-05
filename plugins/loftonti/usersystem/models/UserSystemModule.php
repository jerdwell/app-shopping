<?php namespace LoftonTi\Usersystem\Models;

use Model;
use Illuminate\Support\Str;

/**
 * Model
 */
class UserSystemModule extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'loftonti_usersystem_modules';

    /**
     * @var array
     */
    public $fillable = [
        'module_name',
        'description',
        'slug'
    ];

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
     * Event before create a record
     * @method
     */
    public function beforeCreate()
    {
        $this -> slug = Str::slug($this -> module_name);
        $exists = $this -> where('slug', $this -> slug)
            -> first();
        if(!empty($exists)) throw new \Exception("No se puede crear este módulo ya que se encuentra asignado.");
    }
    
    /**
     * Event before update a record
     * @method
     */
    public function beforeUpdate()
    {
        $slug = Str::slug($this -> module_name);
        if($slug != $this -> slug) {
            $exists = $this -> where('slug', $slug)
                -> first();
            if(!empty($exists)) throw new \Exception("Este módulo ya se encuentra registrado");
        }
        $this -> slug = $slug;
        
    }

}
