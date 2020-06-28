<?php namespace AppProducts\Products\Models;

use Illuminate\Support\Facades\DB;
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

    /** Events */

    public function beforeSave()
    {
        DB::table('appproducts_products_brands_details')
        ->where('product_id', $this -> id)
        ->delete();
    }

    public function afterEach()
    {
        $this -> product_brands = $this -> product_brands;
    }

    /* Relations */

    public $belongsToMany = [
        'categories' => [
            'AppProducts\Products\Models\Categories',
            'table' => 'appproducts_products_pivot_p_cat',
            'key'      => 'product_id',
            'otherKey' => 'category_id',
            'order' => 'category'
        ],

        'tags' => [
            'AppProducts\Products\Models\Tags',
            'table' => 'appproducts_products_prod_tag',
            'key'      => 'product_id',
            'otherKey' => 'tag_id',
            'order' => 'tag_name'
        ],
        
        'product_brands' => [
            'AppProducts\Products\Models\Brand',
            'table' => 'appproducts_products_brands_details',
            'key' => 'product_id',
            'otherKey' => 'brand_id',
            'pivot' => [
                'brand_code',
                'brand_price',
                'brand_public_price',
                'brand_remark'
            ]
        ]
    ];

    public $attachOne = [
        'product_cover' => 'System\Models\File',
    ];
    
    public $attachMany = [
        'product_gallery' => 'System\Models\File',
    ];

}
