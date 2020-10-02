<?php namespace Loftonti\Erso\Models;

use Model;
use Illuminate\Support\Str;

/**
 * Model
 */
class Branches extends Model
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
    public $table = 'loftonti_erso_branches';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var array jsonable to asign json data in database
     */
    public $jsonable = [
        'contact_data'
    ];

    /**
     * Events
     */
    public function beforeSave()
    {
        $this -> slug = Str::slug($this->branch_name);
    }

    /**
     * @var array belongsToMany set the relationships into the model
     */
    public $belongsToMany = [
        'products' => [
            'Loftonti\Erso\Models\Products',
            'table' => 'loftonti_erso_product_branch',
            'key' => 'branch_id',
            'otherKey' => 'product_id',
            'pivot' => ['stock']
        ],
    ];

}
