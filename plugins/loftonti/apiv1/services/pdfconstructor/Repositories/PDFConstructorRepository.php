<?php

namespace LoftonTi\Apiv1\Services\PDFConstructor\Repositories;

use Barryvdh\DomPDF\Facade as PDF;
use LoftonTi\Apiv1\Services\PDFConstructor\Contracts\PDFConstructorContracts;

class PDFConstructorRepository implements PDFConstructorContracts
{

  public function streamReceipt(array $data, string $view): object
  {
    $pdf = PDF::loadView($view, $data);
    return $pdf -> stream(time() . ".pdf");
  }

}