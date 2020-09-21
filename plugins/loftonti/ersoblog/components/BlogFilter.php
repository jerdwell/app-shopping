<?php namespace Loftonti\ersoblog\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use LoftonTi\ErsoBlog\Models\Categories;
use LoftonTi\ErsoBlog\Models\Posts;

class BlogFilter extends ComponentBase
{
    public $errors, $posts, $categories;
    public function componentDetails()
    {
        return [
            'name'        => 'blogFilter',
            'description' => 'filter blog for category'
        ];
    }

    public function defineProperties()
    {
        return [
            'filter' => [
                'title' => 'Tipo de filtro',
                'description' => 'Tipo de filtro por el cual se realizará la búsqueda',
            ],
            'per' => [
                'title' => 'Blogs por página',
                'description' => 'Blogs que se mostraran en el listado por página',
                'default' => 9,
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'El dato para el número de blogs por página debe de ser un número'
            ],
            'values' => [
                'title' => 'Valor de los filtros',
                'description' => 'Valor del filtro por el cual se realizará la búsqueda.',
            ]
        ];
    }

    public function onRun()
    {
        try {
            $filter_type = $this -> property('filter');
            $per = $this -> property('per');
            $values = $this -> property('values');
            $valid = Validator::make(
                [
                    'filter' => $filter_type,
                    'per' => $per
                ],
                [
                    'filter' => 'required|string|' . Rule::in(['categories', 'date']),
                    'per' => 'required|integer',
                ]
            );
            if($valid -> fails()){
                if($valid -> errors() -> has('filter')) throw new \Exception('Este filtro no es correcto.');
                if($valid -> errors() -> has('per')) throw new \Exception('El número de resultados no es correcto.');

            }
            $this -> categories = Categories::paginate(10);
            $this -> posts = $this -> filterPosts() -> with([ 'cover', 'categories' ]) -> paginate($per);
        } catch (\Throwable $th) {
            $this -> errors = $th -> getMessage();
        }
    }

    public function filterPosts()
    {
        $filter = $this -> property('filter');
        $values = $this -> property('values');
        $values = explode(',', $values);
        if(count($values) > 2) throw new \Exception('Error en las fechas');
        switch ($filter) {
            case 'categories':
                return Posts::filterByCategories($values) -> orderBy('id', 'desc');
                break;
            case 'date':
                return Posts::whereBetween('loftonti_ersoblog_posts.created_at', $values) -> orderBy('id', 'desc');
                break;
            
            default:
                throw new \Exception('Error en la búsqueda');
                break;
        }
    }

}
