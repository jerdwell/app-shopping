<?php

namespace LoftonTi\Apiv1\Services\Customers\Jobs;

use Illuminate\Support\Facades\Mail;

class CustomerRegisterNotification
{
  public function fire($job, Array $customer)
  {
    try {
      Mail::send('loftonti.apiv1::email.customer-register', [
        'email' => $customer['email'],
        'full_name' => $customer['full_name'],
        'password' => $customer['password'],
      ], function ($message) use($customer){
        $message -> to($customer['email'])
          -> subject('Registro de usuario');
      });
      $job -> delete();
    } catch (\Throwable $th) {
      print_r($th -> getMessage());
      $job -> delete();
    }
  }
}