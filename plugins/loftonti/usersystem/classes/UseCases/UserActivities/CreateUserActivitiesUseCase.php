<?php

namespace Loftonti\Usersystem\Classes\UseCases\UserActivities;

use LoftonTi\Usersystem\Models\UserSystemActivities;

class CreateUserActivitiesUseCase
{

  /**
   * @var int
   */
  private $user_id, $response_code;
  
  /**
   * @var string
   */
  private $type, $request, $response;

  public function __construct(int $user_id, int $response_code, string $type, string $request, string $response) {
    $this->user_id = $user_id;
    $this->response_code = $response_code;
    $this->type = $type;
    $this->request = $request;
    $this->response = $response;
    $this -> saveData();
  }

  
  private function saveData()
  {
    try {
      UserSystemActivities::create([
        'user_id' => $this->user_id,
        'response_code' => $this->response_code,
        'type' => $this->type,
        'request' => $this->request,
        'response' => $this->response
      ]);
    } catch (\Throwable $th) {
      return false;
    }
  }
  
}
