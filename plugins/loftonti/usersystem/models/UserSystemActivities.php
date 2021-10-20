<?php namespace LoftonTi\Usersystem\Models;

use Model;

/**
 * Model
 */
class UserSystemActivities extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * use timestapms created_at and updated_at
     * @var bool
     */
    public $timestamps = true;

    /**
     * Data to fillable
     * @var array
     */
    public $fillable = [
        'user_id',
        'type',
        'request',
        'response',
        'response_code'
    ];
    
    /**
     * @var string The database table used by the model.
     */
    public $table = 'loftonti_usersystem_activities_user';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var array
     */
    public $belongsTo = [
        'user' => 'LoftonTi\Usersystem\Models\UserSystem'
    ];
}
