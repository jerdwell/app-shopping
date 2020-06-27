<?php namespace AppProducts\Products\Models;

use Model;
use October\Rain\Support\Str;

/**
 * Model
 */
class Categories extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'appproducts_products_categories';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];


    /** Relations **/

    public $belongsToMany = [
        'products' => [
            'AppProducts\Products\Models\Products',
            'table' => 'appproducts_products_pivot_p_cat',
            'key'      => 'category_id',
            'otherKey' => 'product_id',
            'order' => 'Product'
        ]
    ];

    public $attachOne = [
        'cover_category' => 'System\Models\File'
    ];

    /** events */

    public function beforeSave()
    {
        $this -> slug = Str::slug($this -> category);
    }

}
