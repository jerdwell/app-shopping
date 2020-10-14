<?php namespace LoftonTi\Quotations\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendAuth;
use BackendMenu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Loftonti\Erso\Models\Branches;
use LoftonTi\Quotations\Models\Quotations as ModelsQuotations;
use Loftonti\Quotations\Models\QuotationsConstructor;
use LoftonTi\Users\Models\Users;
use LoftonTi\Users\Models\UsersAuth;

class Quotations extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController'    ];
    
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('LoftonTi.Quotations', 'main-menu-item');
    }

    public function create(Request $request)
    {
        try {
            $user = Users::find($request -> data_user['id']);
            $user -> address;
            $data_quotation = $this -> setDataQuotation($request, $user);
            $branch = Branches::where('slug', $request -> branch)->first();
            $quotation = ModelsQuotations::create($data_quotation);
            $this -> sendNotification($user, $quotation, self::setMailBranch($branch));
            return ['Cotización solicitada exitosamente'];
        } catch (\Throwable $th) {
            return $th -> getMessage();
            return response($th -> getMessage(), 403);
        }
    }

    public function setDataQuotation($request, $user)
    {
        return [
            'items' => json_encode($request -> items),
            'amount' => $request -> amount,
            'status' => isset($request -> data_user) ? 'active' : 'standby',
            'shipping_address' => isset($request -> data_user) ? json_encode(ModelsQuotations::SetDataQuotationAddress($user -> address)) : null,
            'shipping_date' => isset($request -> data_user) && isset($request -> shipping_date) ? Carbon::parse($request -> shipping_date) -> format('Y-m-d') : null,
            'shipping_contact' => isset($request -> data_user) ? json_encode(ModelsQuotations::setDataContactQuotation($user)) : null,
            'branch' => isset($request -> data_user) ? $request -> branch : null,
            'user_id' => isset($request -> data_user) ? $request -> data_user['id'] : null,
            'created_at' => Carbon::now() -> format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now() -> format('Y-m-d H:i:s')
        ];
    }

    public function sendNotification($user, $quotation, $mail_branch)
    {
        try {
            $mail_data = [
                'name' => $user -> firstname . ' ' . $user -> lastname,
                'email' => $user -> email,
                'phone' => $user -> phone,
                'id' => $quotation -> id,
                'shipping_date' => $quotation -> shipping_date,
                'shipping_address' => $quotation -> shipping_address,
                'items' => $quotation -> items,
                'amount' => $quotation -> amount
            ];
            Mail::send('loftonti.quotations::mail.quotation-created', $mail_data, function($message) use($mail_data, $mail_branch){
                $message->to($mail_branch, $mail_data['name']);
                $message->subject('Nueva órden de compra.');
            });
            Mail::send('loftonti.quotations::mail.quotation-created-user', $mail_data, function($message) use($mail_data, $mail_branch){
                $message->to($mail_data['email'], $mail_data['name']);
                $message->subject('Nueva órden de compra.');
            });
        } catch (\Throwable $th) {
            throw $th;
            return false;
        }
    }

    public static function setMailBranch($branch)
    {
        $mails = [];
        foreach ($branch -> contact_data as $data) {
            if($data['type'] == 'email') array_push($mails, $data['data']);
        }
        return $mails;
    }

    public function list(Request $request)
    {
        try {
            $list = ModelsQuotations::where('user_id', $request -> data_user['id']) -> orderBy('id', 'desc') -> paginate(30);
            return $list;
        } catch (\Throwable $th) {
            return response($th -> getMessage(), 403);
        }
    }

    public function get(Request $request, $id, $token)
    {
        try {
            $request -> headers -> set('Authorization', $token);
            UsersAuth::validRequest($request);
            if(!$request -> data_user) throw new \Exception('Credenciales inválidas');
            $quotation = ModelsQuotations::where('id', $id)
            -> where('user_id', $request -> data_user['id'])
            ->first();
            $branch = Branches::where('slug', $quotation -> branch) -> first();
            return QuotationsConstructor::buildQuotation($quotation, $branch, $view = 'download');
        } catch (\Throwable $th) {
            return response($th -> getMessage(),404);
            return response('Credenciales inválidas',404);
        }
    }

    public function cancelQuotation(Request $request)
    {
        try {
            $valid = Validator::make($request -> all(), [
                'id' => 'required|integer|exists:loftonti_quotations_quotations,id',
                'message' => 'required|string|min:10|max:250'
            ]);
            if($valid -> fails()) throw new \Exception('Esta órden no se puede cancelar, revisa los parámetros de la misma.');
            $order = ModelsQuotations::find($request -> id);
            if($order -> status != 'active') throw new \Exception('Esta órden no se puede cancelar.');
            if($order -> user_id  != $request -> data_user['id']) throw new \Exception('Esta órden no se puede cancelar.');
            $created_at = (string)($order -> created_at);
            if(Carbon::now() -> greaterThan(Carbon::parse($created_at)->addHours(3))) throw new \Exception('Esta órden no puede ser cancelada, em tiempo máximo de cancelación es de 3 horas.');
            $branch = Branches::where('slug', $order -> branch)->first();
            $user = Users::find($request -> data_user['id']);
            $mails = self::setMailBranch($branch);
            $mail_data = [
                'id' => $order ->id,
                'message_cancel' => $request -> message,
                'name' => $request -> data_user['name'],
                'email' => $user -> email,
                'phone' => $user -> phone,
                'branch' => $branch -> branch_name
            ];
            $order -> update(['status' => 'declined']);
            Mail::send('loftonti.quotations::mail.order-canceled', $mail_data, function($mail) use($mails, $branch) {
                $mail->to($mails, 'ERSO ' . $branch -> branch_name);
                $mail->subject('Cancelación de órden.');
            });
            return ['Órden cancelada exitosamente.'];
        } catch (\Throwable $th) {
            return response([$th -> getMessage()], 403);
        }
    }

    public function download($id)
    {
        try {
            $quotation = ModelsQuotations::where('id', $id)->first();
            $branch = Branches::where('slug', $quotation -> branch) -> first();
            return QuotationsConstructor::buildQuotation($quotation, $branch, $view = 'stream');
        } catch (\Throwable $th) {
            return response($th -> getMessage(),403);
        }
    }

    public function onUpdateStatus()
    {
        try {
            $status = Input::get('status');
            $id = Input::get('id');
            $quotation = ModelsQuotations::find($id);
            $quotation -> update(['status' => $status]);
            return ['Cotización actualizada exitosamente'];
        } catch (\Throwable $th) {
            return response($th -> getMessage(), 403);
        }
    }

    public function downloable(Request $request)
    {
        try {
            $user = isset($request -> data_user) ? Users::find($request -> data_user['id']) : (object) []; 
            $quotation = $this -> setDataQuotation($request, $user);
            $branch = Branches::where('slug', $request -> branch)->first();
            $data = [
                $quotation,
                $branch,
                'stream',
                Carbon::now() -> addMinutes(3) -> format('Y-m-d H:i:s')
            ];
            $data = Crypt::encryptString(json_encode($data));
            return [
                "url" => "api/v1/quotations/download/temp/{$data}"
            ];
        } catch (\Throwable $th) {
            return response($th -> getMessage(), 403);
        }
    }

    public function tempQuotation($data)
    {
        try {
            $data = Crypt::decryptstring($data);
            $data = json_decode($data);
            if(Carbon::now() -> greaterThan($data[3])) throw new \Exception("Esta página ha expirado");
            $data[0] -> items = json_decode($data[0] -> items);
            if(isset($data[0] -> shipping_contact)) $data[0] -> shipping_contact = json_decode($data[0] -> shipping_contact);
            if(isset($data[0] -> shipping_address)) $data[0] -> shipping_address = json_decode($data[0] -> shipping_address);
            return QuotationsConstructor::buildQuotation($data[0], $data[1], $data[2]);
        } catch (\Throwable $th) {
            return  redirect('/');
        }
    }

}
