<?php

namespace LoftonTi\Apiv1\Services\Broadcast\Contracts;

interface BroadcastContracts
{

  public function notifyBroadcastPost(string $endpoint, ?array $data, ?array $headers): ?object;

}