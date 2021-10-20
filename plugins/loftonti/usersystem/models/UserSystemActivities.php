<?php namespace LoftonTi\Usersystem\Models;

use Model;

/**
 * Model
 */
class UserSystemActivities extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'loftonti_usersystem_activities_user';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
