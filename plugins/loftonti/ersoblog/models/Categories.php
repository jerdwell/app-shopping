<?php namespace LoftonTi\ErsoBlog\Models;

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


    /**
     * @var string The database table used by the model.
     */
    public $table = 'loftonti_ersoblog_categories';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function beforeCreate()
    {
        $this -> slug = Str::slug($this -> name);
    }

    public $belongsToMany  = [
        'posts' => [
            'LoftonTi\ErsoBlog\Models\Posts',
            'table' => 'loftonti_ersoblog_post_category',
            'key' => 'post_id',
            'otherKey' => 'category_id'
        ]
    ];

    public $attachOne = [
        'cover' => 'System\Models\File'
    ];

}
