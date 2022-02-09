<?php

namespace LoftonTi\Apiv1\Services\PDFConstructor\UseCase;

use LoftonTi\Apiv1\Services\PDFConstructor\Repositories\PDFConstructorRepository;

class StreamPDFUseCase
{
  /**
   * @var string
   */
  private $view;
  /**
   * @var object
   */
  private $repository;
  /**
   * @var array
   */
  private $data;

  public function __construct(array $data, string $view) {
    $this->data = $data;
    $this->view = $view;
    $this->repository = new PDFConstructorRepository;
  }

  public function __invoke()
  {
    return $this 
      -> repository 
      -> streamReceipt($this -> data, $this -> view);
  }

}