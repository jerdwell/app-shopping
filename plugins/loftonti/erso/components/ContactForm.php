<?php namespace Loftonti\erso\Components;

use Cms\Classes\ComponentBase;

class ContactForm extends ComponentBase
{
    public $email;
    public function componentDetails()
    {
        return [
            'name'        => 'ContactForm',
            'description' => 'Componente de formulario de contacto'
        ];
    }

    public function defineProperties()
    {
        return [
            'email' => [
                'title' => 'email',
                'description' => 'email list to get data form',
                'type' => 'string',
            ],
        ];
    }

}
