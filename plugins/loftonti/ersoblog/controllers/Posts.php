<?php namespace LoftonTi\ErsoBlog\Controllers;

use Backend\Classes\Controller;
use Illuminate\Http\Request;
use BackendMenu;
use LoftonTi\ErsoBlog\Models\Posts as ModelsPosts;

class Posts extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\RelationController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('LoftonTi.ErsoBlog', 'main-menu-item');
    }
    public function formExtendModel($model)
    {
        $this->initRelation($model);
    }

    public function search(Request $request)
    {
        try {
            $posts = ModelsPosts::where('title', 'like', "%{$request->data}%") -> with(['cover']) -> take(10) -> get();
            return $posts;
        } catch (\Throwable $th) {
            return response([$th -> getMessage()], 403);
        }
    }
    
}
