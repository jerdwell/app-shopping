<?php namespace Loftonti\Erso\Models;

use Model;

/**
 * Model
 */
class Applications extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'loftonti_erso_application';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var array belongs to many to set relation many to many
     */

    public $belongstoMany = [
        // 'products' => [
        //     'Loftonti\Erso\Models\Branches',
        //     'table' => 'loftonti_erso_product_branch',
        //     'key' => 'product_id',
        //     'otherKey' => 'branch_id',
        //     'pivot' => ['stock', 'enterprise_id']
        // ],
    ];

}
