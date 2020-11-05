<?php namespace Loftonti\Erso\Controllers;

use Backend\Classes\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactForm extends Controller
{

  public function contactForm(Request $request)
  {
      try {
        $this -> validCaptcha($request);
        $this -> validFormData($request);
        $FORM_CONTACT_MAIL = config('formcontact.FORM_CONTACT_MAIL');
        $mail_data = [
          'name' => $request -> name, 
          'email' => $request -> email, 
          'phone' => $request -> phone, 
          'comments' => $request -> comments, 
        ];
        Mail::send('loftonti.erso::mail.form-contact', $mail_data, function($message) use ($FORM_CONTACT_MAIL, $request){
          $message->to($FORM_CONTACT_MAIL, $request -> name);
          $message->subject('Nuevo mensaje de contacto.');
        });
        return ['Mensaje enviado exitosamente'];
    } catch (\Throwable $th) {
      return response($th -> getMessage(), 403);
    }
  }

  public function validCaptcha($data)
  {
    $CAPTCHA_SITE_KEY = config('recaptcha.RE_CAPTCHA_SITE_KEY');
    $CAPTCHA_SK = config('recaptcha.RE_CAPTCHA_SK');
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
    'secret' => $CAPTCHA_SK,
    'response' => $data -> recaptcha_token,
    'remoteip' => $_SERVER['REMOTE_ADDR']
    );
    $curlConfig = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $data
    );
    $ch = curl_init();
    curl_setopt_array($ch, $curlConfig);
    $response = curl_exec($ch);
    curl_close($ch);
    $jsonResponse = json_decode($response);
    if($jsonResponse->success != true) throw new \Exception('Los datos de recaptcha no son válidos');
  }

  public function validFormData($data)
  {
    $valid = Validator::make($data -> all(), [
      'name' => 'required|string|min:2|max:150',
      'email' => 'required|email',
      'phone' => 'required|digits:10',
      'comments' => 'required|string|min:10|max:200',
    ]);
    if($valid -> fails()){
      if($valid -> errors() -> has('name')) throw new \Exception('El nombre no es un dato válido');
      if($valid -> errors() -> has('email')) throw new \Exception('El correo no es un dato válido');
      if($valid -> errors() -> has('phone')) throw new \Exception('El teléfono no es un dato válido');
      if($valid -> errors() -> has('comments')) throw new \Exception('Los comentarios no son un dato válido');
    }
  }

  
  // function relateTest()
  // {
  //   $total = DB::table('loftonti_erso_products') -> selectRaw('count(*) as total') -> first();
  //   // return [$total -> total];
  //   $query = [];
  //   for ($i=0; $i < $total -> total; $i++) { 
  //     array_push($query, ['product_id' => $i, 'branch_id' => 1, 'stock' => random_int(0, 200)]);
  //     array_push($query, ['product_id' => $i, 'branch_id' => 2, 'stock' => random_int(0, 200)]);
  //     array_push($query, ['product_id' => $i, 'branch_id' => 3, 'stock' => random_int(0, 200)]);
  //   }
  //   // return $query;
  //   return DB::table('loftonti_erso_product_branch') -> insert($query);
  // }

}