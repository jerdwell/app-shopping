<?php namespace Loftonti\Erso\Models;

use Model;
use Illuminate\Support\Str;

/**
 * Model
 */
class Products extends Model
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
    public $table = 'loftonti_erso_products';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /** Events */

    public function beforeSave()
    {
        $this -> product_slug = Str::slug($this -> product_name);
    }

    /** Relations */

    public $belongsTo = [
        'brand' => [ 'Loftonti\Erso\Models\Brands' ],
        'category' => [ 'Loftonti\Erso\Models\Categories' ],
        'shipowner' => [ 'Loftonti\Erso\Models\Shipowners' ],
        'enterprise' => [ 'Loftonti\Erso\Models\enterprises' ]
    ];

}
