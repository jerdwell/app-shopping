<?php

namespace LoftonTi\Usersystem\Classes\UseCases\Products;

use Illuminate\Support\Facades\Mail;

class CreateProductsQueueUseCase
{

  /**
   * @param array $items products to create
   * @param int $user_id user to upload product
   * @param int $branch_id user to upload product
   */
  public function fire($job, $data)
  {
    try {
      $use_case = new CreateProductUseCase($data['items'], $data['branch_id']);
      $process = $use_case();
      Mail::send('loftonti.usersystem::mail.layout-processed', $process, function($message) {
        $message -> to('jmoreno@loftonsc.com') -> subject('Carga de layout');
      });
      $job ->delete();
    } catch (\Throwable $th) {
      $job ->delete();
    }
  }

}