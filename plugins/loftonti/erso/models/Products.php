<?php namespace Loftonti\Erso\Models;

use Model;

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

    public $belongsTo = [
        'brand_id' => [ 'Loftonti\Erso\Models\Brands' ],
        'category_id' => [ 'Loftonti\Erso\Models\Categories' ],
        'enterprise_id' => [ 'Loftonti\Erso\Models\Enterprises' ],
        'shipowner_id' => [ 'Loftonti\Erso\Models\Shipowners' ],
    ];

}
