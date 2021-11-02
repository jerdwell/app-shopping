<?php namespace Loftonti\Components\Components;

use Cms\Classes\ComponentBase;
use LoftonTi\Components\Models\SlideComponent as ModelsSlideComponent;

class SlideComponent extends ComponentBase
{
    public $data_slide;
    public function componentDetails()
    {
        return [
            'name'        => 'slideComponent',
            'description' => 'Slide de inicio'
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $slide = ModelsSlideComponent::all();
        $this -> data_slide = $slide;
    }
}
