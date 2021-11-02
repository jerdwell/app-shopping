<?php namespace Loftonti\Erso\Models;

use Model;
use Illuminate\Support\Str;

/**
 * Model
 */
class Brands extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'loftonti_erso_brands';

    /**
     * @var array Validation rules
     */
    public $rules = [
        // 'brand_name' => 'unique:loftonti_erso_brands,brand_name'
    ];

    /** Events */

    public function beforeSave()
    {
        $this -> brand_slug = Str::slug($this -> brand_name);
    }

    /** Relations */

    public $hasMany = [
        'product_id' => 'Loftonti\Erso\Models\Products'
    ];

}
