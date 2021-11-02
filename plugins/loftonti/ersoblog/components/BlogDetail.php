<?php namespace Loftonti\ersoblog\Components;

use Cms\Classes\ComponentBase;
use LoftonTi\ErsoBlog\Models\Categories;
use LoftonTi\ErsoBlog\Models\Posts;

class BlogDetail extends ComponentBase
{
    public $errors, $post, $related, $categories;

    public function componentDetails()
    {
        return [
            'name'        => 'blogDetail',
            'description' => 'Get post detail'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title' => 'slug del post',
                'description' => 'Slug para buscar el detalle de la noticia',
            ],
        ];
    }

    public function onRun()
    {
        try {
            $post = $this -> post = Posts::where('slug', $this -> property('slug')) -> with(['categories', 'cover']) -> first();
            $related_categories = $post -> categories;
            $related_categories = array_column(json_decode(json_encode($related_categories)), 'slug');
            $this -> categories = Categories::paginate(10);
            $this -> related = Posts::filterByCategories($related_categories) -> where('loftonti_ersoblog_posts.slug', '!=', $this -> property('slug')) -> orderBy('id', 'desc') -> take(6) -> get();
        } catch (\Throwable $th) {
            return $th -> getMessage();
        }
    }

}
