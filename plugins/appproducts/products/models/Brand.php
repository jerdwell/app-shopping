<?php namespace AppProducts\Products\Models;

use Model;
use October\Rain\Support\Str;

/**
 * Model
 */
class Brand extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'appproducts_products_brands';

    /**
     * @var array Validation rules
     */
    public $rules = [];


    /** Relations */

    public $attachOne = [
        'brand_logo' => 'System\Models\File'
    ];

    public function beforeSave()
    {
        $this -> brand_slug = Str::slug($this -> brand_name);
    }
}
