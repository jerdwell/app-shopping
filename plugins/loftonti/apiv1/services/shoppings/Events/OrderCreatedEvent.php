<?php

namespace LoftonTi\Apiv1\Services\Shoppings\Events;

use Loftonti\Apiv1\Services\Auth\UseCase\BroadcastHandler;
use LoftonTi\Apiv1\Services\Broadcast\Repository\BroadcastRepository;

class OrderCreatedEvent
{

  public function fire($job, $data)
  {
    try {
      $curl = new BroadcastRepository;
      $crypt_handler = new BroadcastHandler;
      $token = $crypt_handler -> crypt([
        'order_id' => $data['order_id'],
        'branch_id' => $data['branch_id']
      ]);
      $headers = [
        "Authorization: Bearer $token"
      ];
      $data = [
        "order_id" => $data['order_id'],
        "branch_id" => $data['branch_id'],
      ];
      $request = $curl -> notifyBroadcastPost(getenv('BROADCAST_URL') . '/order/new-order', $data, $headers);
      $job -> delete();
    } catch (\Throwable $th) {
      $job -> delete();
    }
  }

}