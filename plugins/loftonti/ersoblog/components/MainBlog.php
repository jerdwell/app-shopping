<?php namespace Loftonti\ErsoBlog\Components;

use Cms\Classes\ComponentBase;
use LoftonTi\ErsoBlog\Models\Categories;
use LoftonTi\ErsoBlog\Models\Posts;

class MainBlog extends ComponentBase
{
    public $posts, $main_post, $categories;

    public function componentDetails()
    {
        return [
            'name'        => 'MainBlog',
            'description' => 'Principal view of blog page'
        ];
    }

    public function defineProperties()
    {
        return [
            'posts' => [
                'title' => 'Blogs por página',
                'description' => 'Blogs que se mostraran en el listado por página',
                'default' => 9,
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'El dato para el número de blogs por página debe de ser un número'
            ]
        ];
    }

    public function onRun()
    {
        $limit = $this -> property('posts');
        $this -> categories = Categories::paginate(10);
        $this -> posts = Posts::where('status', 'published')
            -> take($limit)
            -> with([ 'cover', 'categories' ])
            -> orderBy('id', 'desc') -> skip(1) -> get();
        $this -> main_post = Posts::where('status', 'published') -> with([ 'cover', 'categories' ]) -> orderBy('id', 'desc') -> first();
    }
}
