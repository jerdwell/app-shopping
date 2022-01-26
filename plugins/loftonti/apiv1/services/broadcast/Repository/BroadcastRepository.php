<?php

namespace LoftonTi\Apiv1\Services\Broadcast\Repository;

use LoftonTi\Apiv1\Services\Broadcast\Contracts\BroadcastContracts;

class BroadcastRepository implements BroadcastContracts
{
  /**
   * @var object
   */
  private $curl;

  public function __construct() {
    $this -> curl = curl_init();
  }

  public function notifyBroadcastPost(string $url, ?array $data, ?array $headers): ?object
  {
    try {
      curl_setopt($this -> curl, CURLOPT_URL, $url);
      // SSL important
      curl_setopt($this -> curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($this -> curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($this -> curl, CURLOPT_POST, true);
      curl_setopt($this -> curl, CURLOPT_CUSTOMREQUEST, 'POST');
      curl_setopt($this -> curl, CURLOPT_POSTFIELDS, $data);
      curl_setopt($this -> curl, CURLOPT_HTTPHEADER, $headers);
      $output = curl_exec($this -> curl);
      // $status_code = curl_getinfo($this -> curl, CURLINFO_HTTP_CODE);
      // if (intval($status_code) != 200  intval($status_code) != 201) throw new \Exception("Unexpected HTTP code: $status_code");
      curl_close($this -> curl);
      return json_decode($output);
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}