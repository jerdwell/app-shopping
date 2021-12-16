<?php

namespace LoftonTi\Apiv1\Services\Auth\UseCase;

use Loftonti\Apiv1\Services\Auth\UseCase\MakeTokenUseCase;

class UserSystemMakeToken
{

  public function __invoke(object $user)
  {
    $auth = new MakeTokenUseCase(
      $user -> id,
      $user -> firstname . ' ' . $user -> lastname,
      $user -> pk,
      [
        'rol' => $user -> rol,
        'branches' => $user -> branches,
      ]
    );
    return [
      'user' => [
        "id" => $user -> id,
        "name" => $user -> firstname . ' ' . $user -> lastname,
        "rol" => $user -> rol,
        "branches" => $user -> branches,
        "avatar" => $user -> avatar,
      ],
      'token' => $auth -> getToken()
    ];
  }

}