<?php namespace Loftonti\Erso\Components;

use Cms\Classes\ComponentBase;
use Loftonti\Erso\Models\Categories;

class ListCategories extends ComponentBase
{
    public $list_categories, $branch;

    public function componentDetails()
    {
        return [
            'name'        => 'Categories list',
            'description' => 'Listado de categorías por bloque'
        ];
    }

    public function defineProperties()
    {
        return [
            'branch' => [
                'title' => 'branch',
                'description' => 'ERSO branch to get stock',
                'type' => 'string',
                'validationPattern' => '^[a-z0-9-]+$'
            ]
        ];
    }

    public function onRun()
    {
        $this -> branch = $this -> property('branch');
        $this -> list_categories = Categories::orderBy('order') -> get();
    }
}
