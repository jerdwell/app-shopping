<?php namespace LoftonTi\Users\Models;

use Exception;
use Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

/**
 * Model
 */
class Users extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    /**
     * @var array filable to fill all public vars
     */

     public $fillable = [
        "firstname",
        "lastname",
        "email",
        "phone",
        "password",
        "token_remember",
        "deleted_at",
        "mail_confirm",
     ];

    protected $password_unhashed = '';

    /**
     * @var string The database table used by the model.
     */
    public $table = 'loftonti_users_users';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'firstname' => 'required|string|min:2|max:150',
        'lastname' => 'required|string|min:2|max:150',
        'email' => 'required|email|unique:loftonti_users_users,email',
        'phone' => 'required|numeric|unique:loftonti_users_users,email',
    ];

    public function beforeCreate()
    {
        if(!isset($this -> password)) $password_unhashed = Str::random(12);
        $this -> password_unhashed = isset($this -> password) ? $this -> password : $password_unhashed;
        if(isset($password_unhashed)) $this -> token_remember = Str::random(30);
        $this -> password = isset($password_unhashed) ? Hash::make($password_unhashed) : Hash::make($this -> password);
    }

    public function afterCreate()
    {
        $token = $this -> makeTokenRegister();
        $mailData = [
            'name' => $this -> firstname . ' ' . $this -> lastname,
            'password' => $this -> password_unhashed,
            'email' => $this -> email,
            'token' => '/account/activate/' . $token,
        ];
        Mail::send('loftonti.users::mail.register', $mailData, function($message) use($mailData){
            $message -> to($mailData['email'], 'info@erso.com.mx');
            $message -> subject('Registro de usuario.');
        });
    }

    /**
     * Events
     */

    public function makeTokenRegister()
    {
        $data_token = [
            'email' => $this -> email,
            'expires' => Carbon::now() -> addMonth(2) -> format('Y-m-d H:i:s'),
        ];
        $token = Crypt::encryptString(json_encode($data_token));
        return $token;
    }

    public static function checkTokenRegister($token)
    {
        try {
            if(empty($token)) throw new \Exception('Token inválido');
            $data_user = json_decode(Crypt::decryptString($token));
            $user = Users::where('email', $data_user -> email) -> first();
            if(empty($user)) throw new \Exception('Token inválido');
            if($user -> mail_confirm) throw new \Exception('Token inválido');
            if(Carbon::now() -> greaterThan($data_user -> expires)) throw new \Exception('Token inválido');
            $user -> update(['mail_confirm' => true]);
            return;
        } catch (\Throwable $th) {
            throw new \Exception($th -> getMessage());
        }
    }


    /**
     * Relations
     */

    public $hasOne = [
        'address' => [ 'LoftonTi\Users\Models\UserAddress', 'key' => 'user_id']
    ];

}
