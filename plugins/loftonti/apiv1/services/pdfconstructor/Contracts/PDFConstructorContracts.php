<?php

namespace LoftonTi\Apiv1\Services\PDFConstructor\Contracts;

interface PDFConstructorContracts
{

  public function streamReceipt(array $data, string $view): object;

}