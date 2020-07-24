<?php namespace Loftonti\Erso\Models;

use Model;

/**
 * Model
 */
class ErsoCodes extends Model
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
    public $table = 'loftonti_erso_codes';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
