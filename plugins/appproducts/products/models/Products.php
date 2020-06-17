<?php namespace AppProducts\Products\Models;

use Model;

/**
 * Model
 */
class Products extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'appproducts_products_products';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    protected $jsonable = ['product_metadata'];

    /* Relations */

    public $belongsToMany = [
        'categories' => [
            'AppProducts\Products\Models\Categories',
            'table' => 'appproducts_products_pivot_p_cat',
            'key'      => 'product_id',
            'otherKey' => 'category_id',
            'order' => 'category'
        ]
    ];

    public $attachOne = [
        'product_cover' => 'System\Models\File'
    ];
    
    public $attachMany = [
        'product_gallery' => 'System\Models\File'
    ];

}
