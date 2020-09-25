<?php namespace LoftonTi\Users\Controllers;

use Backend\Classes\Controller;
use Illuminate\Http\Request;
use BackendMenu;
use Cms\Classes\CmsCompoundObject;
use Cms\Classes\Layout;
use Cms\Classes\Page;
use Cms\Classes\Partial;
use Cms\Classes\Theme;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use LoftonTi\Users\Models\Users as ModelsUsers;
use LoftonTi\Users\Models\UsersAuth;

class Users extends Controller
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
    }

    public function registerAccount(Request $request)
    {
        try {
            $this -> validateDataRegister($request);
            DB::transaction(function() use($request){
                $token_remember = Str::random(30);
                $user = ModelsUsers::create([
                    'firstname' => $request -> firstname,
                    'lastname' => $request -> lastname,
                    'email' => $request -> email,
                    'phone' => $request -> phone,
                    'password' => $request -> password,
                    'token_remember' => $token_remember,
                ]);
                $user -> address() -> create([
                    "address1" => $request -> address1,
                    "suburb" => $request -> suburb,
                    "state" => $request -> state,
                    "country" => $request -> country,
                    "city" => $request -> city,
                    "address2" => $request -> address2,
                    "zip_code" => $request -> zip_code,
                ]);
            });
            return ['Usuario registrado exitosamente'];
        } catch (\Exception $th) {
            return response($th -> getMessage(), 403);
        }
    }

    
    public function userLogin(Request $request)
    {
        try {
            $valid = Validator::make($request -> all(), [
                'email' => 'required|email|exists:loftonti_users_users,email',
                'password' => 'required|string|max:20|min:8'
            ]);
            if($valid -> fails()){
                if($valid -> errors() -> has('email')) throw new \Exception('Los datos no son correctos');
                if($valid -> errors() -> has('password')) throw new \Exception('Los datos no son correctos');
            }
            $user = ModelsUsers::where('email', $request -> email) -> where('deleted_at', null) -> where('mail_confirm', true) -> first();
            if(empty($user)) throw new \Exception('Los datos no son corectos');
            if(!Hash::check($request -> password, $user -> password)) throw new \Exception('la contraseña es incorrecta');
            $auth = UsersAuth::MakeToken($user -> id);
            return $auth;
            return $request -> all();
        } catch (\Exception $th) {
            return response($th -> getMessage(), 401);
        }
    }

    public function validateDataRegister($request)
    {
        try {
            $valid = Validator::make($request -> all(),[
                'firstname' => 'required|string|min:2|max:130',
                'lastname' => 'required|string|min:2|max:130',
                'email' => 'required|email|unique:loftonti_users_users,email',
                'phone' => 'required|digits:10|unique:loftonti_users_users,phone',
                'password' => 'required|string|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[.\-!@#_\[\]\{\}\$%\^&\*])(?=.{8,})/',
                'address1' => 'required|string|min:4|max:150',
                'suburb' => 'required|string|min:4|max:150',
                'zip_code' => 'required|digits:5|',
                'state' => 'required|string|min:3|max:130',
                'city' => 'required|string|min:3|max:130',
                'country' => 'required|string|min:3|max:130',
                'address2' => 'nullable|string|max:130',
            ], [
                'firstname.*' => 'El Nombre no es un dato válido.',
                'lastname.*' => 'El Apellido no es un dato válido.',
                'email.*' => 'El correo no es un dato válido o no se puede asignar.',
                'phone.*' => 'El teléfono no es un dato válido.',
                'password.*' => 'La contraseña no cuenta con la longitud (8 caracteres mínimos) combinando mayúsculas y signos',
                'address1.*' => 'La calle y/o número no son datos válidos',
                'suburb.*' => 'La colonia no es un dato válido',
                'zip_code.*' => 'El código postal no es un dato válido',
                'state.*' => 'El estado no es un dato válido',
                'city.*' => 'La ciudad no es un dato válido',
                'country.*' => 'La delegación o municipio no es un dato válido',
                'address2.*' => 'Las referencias no cuentan con los parámetros de longitud(máx: 130).',
            ]);
            if($valid -> fails()){
                if($valid -> errors() -> has('firstname')) throw new \Exception($valid -> errors() -> get('firstname')[0]);
                if($valid -> errors() -> has('lastname')) throw new \Exception($valid -> errors() -> get('lastname')[0]);
                if($valid -> errors() -> has('email')) throw new \Exception($valid -> errors() -> get('email')[0]);
                if($valid -> errors() -> has('phone')) throw new \Exception($valid -> errors() -> get('phone')[0]);
                if($valid -> errors() -> has('password')) throw new \Exception($valid -> errors() -> get('password')[0]);
                if($valid -> errors() -> has('address1')) throw new \Exception($valid -> errors() -> get('address1')[0]);
                if($valid -> errors() -> has('suburb')) throw new \Exception($valid -> errors() -> get('suburb')[0]);
                if($valid -> errors() -> has('zip_code')) throw new \Exception($valid -> errors() -> get('zip_code')[0]);
                if($valid -> errors() -> has('state')) throw new \Exception($valid -> errors() -> get('state')[0]);
                if($valid -> errors() -> has('city')) throw new \Exception($valid -> errors() -> get('city')[0]);
                if($valid -> errors() -> has('country')) throw new \Exception($valid -> errors() -> get('country')[0]);
                if($valid -> errors() -> has('address2')) throw new \Exception($valid -> errors() -> get('address2')[0]);
            }
        } catch (\Exception $th) {
            throw new \Exception($th -> getMessage());
        }
    }

    public function recoveryAccount(Request $request)
    {
        try {
            $valid = Validator::make($request -> all(), [
                'email' => 'email|required|exists:loftonti_users_users,email'
            ]);
            if($valid -> fails()) throw new \Exception(null);
            $user = ModelsUsers::where('email', $request -> email) -> first();
            $special_char = '!#$%&()[]*';
            $password = Str::random(14);
            $password = str_random($special_char) . $password;
            $password = str_shuffle($password);
            $user -> update(['password' => Hash::make($password)]);
            $mailData = [
                'name' => $user -> firstname . ' ' . $user -> lastname,
                'password' => $password,
                'email' => $user -> email,
            ];
            Mail::send('loftonti.users::mail.recovery-account', $mailData, function($message) use($mailData){
                $message -> to($mailData['email'], 'info@erso.com.mx');
                $message -> subject('Registro de usuario.');
            });
            return ['Contraseña recuperada exitosamente.'];
        } catch (\Throwable $th) {
            return response('Contraseña recuperada exitosamente.', 200);
        }
    }

    public function dataAccount(Request $request)
    {
        $id_user = $request -> data_user['id'];
        $user = ModelsUsers::find($id_user);
        $user -> address;
        $user -> makeHidden(['password', 'token_remember', 'updated_at', 'mail_confirm', 'deleted_at', 'created_at']);
        return $user;
    }

    public function updateAccount(Request $request, $action)
    {
        try {
            $user = ModelsUsers::find($request -> data_user['id']);
            switch ($action) {
                case 'personal-data':
                    $validMail = false;
                    $validPhone = false;
                    if($user -> email != $request -> email) $validMail = true;
                    if($user -> phone != $request -> phone) $validPhone = true;
                    $this -> validPersonalData($request, $validMail, $validPhone);
                    $user -> update([
                        'firstname' => $request -> firstname,
                        'lastname' => $request -> lastname,
                        'email' => $request -> email,
                        'phone' => $request -> phone,
                    ]);
                    break;
                case 'address-data':
                    $this -> validAddressData($request);
                    $user ->address() -> update([
                        'address1' => $request -> address1,
                        'suburb' => $request -> suburb,
                        'zip_code' => $request -> zip_code,
                        'country' => $request -> country,
                        'state' => $request -> state,
                        'city' => $request -> city,
                        'address2' => $request -> address2,
                    ]);
                    break;
                
                default:
                    throw new \Exception('Error al intentar actualizar estos datos.');
                    break;
            }
            return ['Datos actualizados exitosamente.'];
        } catch (\Throwable $th) {
            return response($th -> getMessage(), 403);
        }
    }

    public function validPersonalData($data, $validMail, $validPhone)
    {
        try {
            $validPhone = $validPhone ? '|unique:loftonti_users_users,phone' : null;
            $validMail = $validMail ? '|unique:loftonti_users_users,email' : null;
            $valid = Validator::make($data -> all(), [
                'firstname' => 'required|string|min:2|max:150',
                'lastname' => 'required|string|min:2|max:150',
                'email' => 'required|email' . $validMail,
                'phone' => 'required' . $validPhone,
            ], [
                'firstname.*' => 'Lo sentimos, el nombre no es un dato válido',
                'lastname.*' => 'Lo sentimos, el apellido no es un dato válido',
                'email.*' => 'Lo sentimos, el correo no es un dato válido o no puede ser asignado',
                'phone.*' => 'Lo sentimos, el teléfono no es un dato válido o no puede ser asignado',
            ]);
            if($valid -> fails()){
                if($valid -> errors() -> has('firstname')) throw new \Exception($valid -> errors() -> get('firstname')[0]);
                if($valid -> errors() -> has('lastname')) throw new \Exception($valid -> errors() -> get('lastname')[0]);
                if($valid -> errors() -> has('email')) throw new \Exception($valid -> errors() -> get('email')[0]);
                if($valid -> errors() -> has('phone')) throw new \Exception($valid -> errors() -> get('phone')[0]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function validAddressData($data)
    {
        try {
            return $data -> all();
            $valid = Validator::make($data -> all(), [
                'address1' => 'required|string|max:150|min:2',
                'suburb' => 'required|string|max:150|min:2',
                'zip_code' => 'required|string|max:5|min:2',
                'country' => 'required|string|max:150|min:2',
                'state' => 'required|string|max:150|min:2',
                'city' => 'required|string|max:150|min:2',
                'address2' => 'nullable|string|max:150|min:2',
            ]);
            if($valid -> fails()){
                if($valid -> errors() -> has('address1')) throw new \Exception($valid -> errors() -> get('address1')[0]);
                if($valid -> errors() -> has('suburb')) throw new \Exception($valid -> errors() -> get('suburb')[0]);
                if($valid -> errors() -> has('zip_code')) throw new \Exception($valid -> errors() -> get('zip_code')[0]);
                if($valid -> errors() -> has('country')) throw new \Exception($valid -> errors() -> get('country')[0]);
                if($valid -> errors() -> has('state')) throw new \Exception($valid -> errors() -> get('state')[0]);
                if($valid -> errors() -> has('city')) throw new \Exception($valid -> errors() -> get('city')[0]);
                if($valid -> errors() -> has('address2')) throw new \Exception($valid -> errors() -> get('address2')[0]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
