<?php namespace Loftonti\Erso\Models;

use Model;
use Illuminate\Support\Str;

/**
 * Model
 */
class Categories extends Model
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
    public $table = 'loftonti_erso_categories';

    /**
     * @var array Validation rules
     */
    public $rules = [
        // 'category_name' => 'unique:loftonti_erso_categories.category_name,'
    ];

    /** Events */

    public function beforeSave()
    {
        $this -> category_slug = Str::slug($this -> category_name);
    }

}
