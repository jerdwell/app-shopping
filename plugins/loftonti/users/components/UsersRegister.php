<?php namespace LoftonTi\Users\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Redirect;
use LoftonTi\Users\Models\Users;

class UsersRegister extends ComponentBase
{
    public $token, $valid;
    
    public function componentDetails()
    {
        return [
            'name'        => 'Activate User Account',
            'description' => 'Plugin form validate user account',
        ];
    }

    public function defineProperties()
    {
        return [
            'token' => [
                'title' => 'token',
                'description' => 'token to activate account',
            ]
        ];
    }

    public function onRender()
    {
        $this -> page['test'] = '1927364';
        try {
            $this -> token = $this -> property('token');
            $token = Users::checkTokenRegister($this -> token);
            $this -> valid = true;
        } catch (\Exception $th) {
            $valid = false;
            return Redirect::to('/');
        }
    }
}
