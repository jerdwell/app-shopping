<?php namespace Loftonti\Erso\Components;

use Cms\Classes\ComponentBase;
use Loftonti\Erso\Models\Categories;

class ListCategories extends ComponentBase
{
    public $list_categories;

    public function componentDetails()
    {
        return [
            'name'        => 'Categories list',
            'description' => 'Listado de categorías por bloque'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $this -> list_categories = Categories::all();
    }
}
