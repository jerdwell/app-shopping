<?php

namespace LoftonTi\Apiv1\Services\Products\UseCase\Traits;

trait SetProductApplicationsTrait
{

  /**
   * Set data applications with [car_id, shipowner_id, year, note]
   * @method
   */
  public function setApplications(array $applications): array
  {
    $data = [];
    foreach ($applications as $application) {
      $car = $this -> cars -> firstWhere('id', $application['car']['id']);
      $shipowner = $this -> shipowners -> firstWhere('id', $application['shipowner']['id']);
      if (!$shipowner || !$car) throw new \Exception("La aplicación no existe. id de auto: {$application['car']['id']} - id de armadora: {$application['shipowner']['id']}");
      
      $data[] = [
        'car_id' => $application['car']['id'],
        'shipowner_id' => $application['shipowner']['id'],
        'year' => $application['years']['from'] . '-' . $application['years']['to'],
        'note' => $application['note']
      ];
    }
    if (count($data) <= 0) throw new \Exception("No se han podido agregar aplicaciones a este producto.");
    return $data;
  }

}