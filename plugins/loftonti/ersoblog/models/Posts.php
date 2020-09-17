<?php namespace LoftonTi\ErsoBlog\Models;

use Illuminate\Support\Str;
use Model;

/**
 * Model
 */
class Posts extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'loftonti_ersoblog_posts';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * mutators
     */

    public function getExcerptPostAttribute($value)
    {
        return substr(strip_tags($this -> content), 0, 200) . '[...]';
    }
    
    public function setExcerptPostAttribute()
    {
        return substr(strip_tags($this -> content), 0, 200) . '[...]';
    }

    /**
     * Events
     */

    public function beforeCreate()
    {
        $this -> slug = Str::slug($this -> title);
    }
    
    public function beforeUpdate()
    {
        unset($this -> excerpt);
    }

    public function afterFetch()
    {
        $this -> excerpt = $this -> setExcerptPostAttribute();
    }

    /**
     * @var array belongs to Many relations
     */

    public $belongsToMany  = [
        'categories' => [
            'LoftonTi\ErsoBlog\Models\Categories',
            'table' => 'loftonti_ersoblog_post_category',
            'key' => 'category_id',
            'otherKey' => 'post_id'
        ]
    ];

    /**
     * @var array Relations polymorphic
     */
    public $attachOne = [
        'cover' => 'System\Models\File'
    ];
}
