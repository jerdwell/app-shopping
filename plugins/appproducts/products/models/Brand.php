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
    public $rules = [
    ];


    /** Relations */

    public $attachOne = [
        'brand_logo' => 'System\Models\File'
    ];
    
    public $belongToMany = [
        'brands_product' => [
            'AppProducts\Products\Models\Products',
            'table' => 'appproducts_products_brands_details',
            'key' => 'brand_id',
            'otherKey' => 'product_id',
            'pivot' => [
                'brand_code',
                'brand_price',
                'brand_public_price',
                'brand_remark'
            ]
        ]
    ];

    public function beforeSave()
    {
        $this -> brand_slug = Str::slug($this -> brand_name);
    }
}
