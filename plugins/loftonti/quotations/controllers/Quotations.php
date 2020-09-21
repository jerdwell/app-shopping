<?php namespace LoftonTi\Quotations\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Loftonti\Erso\Models\Branches;
use LoftonTi\Quotations\Models\Quotations as ModelsQuotations;
use LoftonTi\Users\Models\Users;

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
                'shipping_address' => json_decode($quotation -> shipping_address),
                'items' => json_decode($quotation -> items),
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

}
