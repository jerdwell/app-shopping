<?php namespace Loftonti\ersoblog\Components;

use Cms\Classes\ComponentBase;
use LoftonTi\ErsoBlog\Models\Posts;

class ListBlogsHome extends ComponentBase
{
    public $main_blog, $list_blogs;
    public function componentDetails()
    {
        return [
            'name'        => 'ListBlogsHome',
            'description' => 'List the blogs to show in homepage'
        ];
    }

    public function defineProperties()
    {
        return [
            'per_page' => [
                'title' => 'Results per page',
                'description' => 'Número de bñpgs para istar en el home',
                'default' => 5,
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'El dato para el número de blogs por página debe de ser un número'
            ],
        ];
    }

    public function onRun()
    {
        $limit = $this -> property('per_page') - 1;
        $this -> main_blog = Posts::orderBy('id','desc') -> with(['cover'])  -> first();
        $this -> list_blogs = Posts::orderBy('id','desc')
            -> with(['cover'])
            -> take($limit)
            -> skip(1)
            -> get();

    }
}
