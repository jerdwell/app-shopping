<?php namespace LoftonTi\Quotations\Controllers;

use Backend\Classes\Controller;
use Backend\Facades\BackendAuth;
use BackendMenu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
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
            $data_quotation = [
                'items' => json_encode($request -> items),
                'amount' => $request -> amount,
                'status' => 'active',
                'shipping_address' => json_encode(ModelsQuotations::SetDataQuotationAddress($user -> address)),
                'shipping_date' => Carbon::parse($request -> shipping_date) -> format('Y-m-d'),
                'shipping_contact' => json_encode(ModelsQuotations::setDataContactQuotation($user)),
                'branch' => $request -> branch,
                'user_id' => $request -> data_user['id'],
                'created_at' => Carbon::now() -> format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now() -> format('Y-m-d H:i:s')
            ];
            $branch = Branches::where('slug', $request -> branch)->first();
            $quotation = ModelsQuotations::create($data_quotation);
            $this -> sendNotification($user, $quotation, self::setMailBranch($branch));
            return ['Cotización solicitada exitosamente'];
        } catch (\Throwable $th) {
            return $th -> getMessage();
            return response($th -> getMessage(), 403);
        }
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

}
