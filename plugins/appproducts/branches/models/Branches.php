<?php namespace AppProducts\Branches\Models;

use Model;

/**
 * Model
 */
class Branches extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'appproducts_branches_branches';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $jsonable = [
        'branch_contact'
    ];

    /** Relations */

    public $belongsToMany = [];

}
