<?php namespace AppProducts\Products\Models;

use Model;

/**
 * Model
 */
class Tags extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'appproducts_products_tags';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    
    /** Relarions */

    public $belongsToMany = [
        'products' => [
            'AppProducts\Products\Models\Products',
            'table' => 'appproducts_products_prod_tag',
            'key'      => 'tag_id',
            'otherKey' => 'product_id',
            'order' => 'Product'
        ]
    ];


}
