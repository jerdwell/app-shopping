<?php

namespace LoftonTi\Apiv1\Services\Products\UseCase\SyncFile;

trait ParseSyncFileUseCase
{
  /**
   * parse file and set data
   * @return array [headers, rows]
   */
  public function parseFile(): void
  {
    $file = fopen($this -> file_path, 'r');
    $rows = array();
    while (($r = fgetcsv($file, 1000, ",")) !== false) {
      $rows[] = $r;
    }
    fclose($file);
    $this -> headers = $rows[0];
    $this -> validHeaders();
    array_shift($rows);
    $this -> rows = $rows;
  }

  /**
   * Valid if headers and data are in place assigned
   * @method
   */
  private function validHeaders(): void
  {
    try {
      $headers = [
        "CVE_ART",
        "DESCR",
        "LIN_PROD",
        "CON_SERIE",
        "CTRL_ALM",
        "EXIST",
        "CVE_IMAGEN",
        "CVE_PRODSERV",
        "CVE_UNIDAD",
        "STATUS",
        "PRECIO",
        "DESCRIPCION",
        "RFC"
      ];
      for ($i=0; $i < count($this -> headers); $i++) { 
        if($this -> headers[$i] != $headers[$i]) throw new \Exception("Las cabeceras no coinciden con el órden establecido.");
      }
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}