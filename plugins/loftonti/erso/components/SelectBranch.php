<?php namespace Loftonti\erso\Components;

use Cms\Classes\ComponentBase;
use Loftonti\Erso\Models\Branches;

class SelectBranch extends ComponentBase
{
    public $branches;
    public function componentDetails()
    {
        return [
            'name'        => 'Select Branch',
            'description' => 'Select branch to get list of categries or products'
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
            ],
        ];
    }

    public function onRun()
    {
        $this -> branches = Branches::all();
    }
}
