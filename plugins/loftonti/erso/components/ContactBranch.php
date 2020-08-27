<?php namespace Loftonti\Erso\Components;

use Cms\Classes\ComponentBase;
use Loftonti\Erso\Models\Branches;

class ContactBranch extends ComponentBase
{
    public $branch_data;

    public function componentDetails()
    {
        return [
            'name'        => 'concatcBranch',
            'description' => 'Componente para mostrar dinámicamente los datos de contacto de cada sucursal'
        ];
    }

    public function defineProperties()
    {
        return [
            'branch' => [
                'title' => 'branch',
                'description' => 'Branch to get data',
                'type' => 'string',
                'validationPattern' => '^[a-z0-9-]+$'
            ],
        ];
    }

    public function onRun()
    {
        $slug = $this -> property('branch');
        $branch = Branches::where('slug', $slug) -> first();
        $this -> branch_data = $branch;
    }
}
