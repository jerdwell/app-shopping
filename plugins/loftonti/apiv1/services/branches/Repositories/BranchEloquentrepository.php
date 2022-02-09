<?php

namespace LoftonTi\Apiv1\Services\Branches\Repositories;

use LoftonTi\Apiv1\services\Branches\Contracts\BranchContracts;
use Loftonti\Erso\Models\Branches;

class BranchEloquentrepository implements BranchContracts
{

  /**
   * @var object
   */
  private $repository;

  public function __construct() {
    $this->repository = new Branches;
  }

  public function getById(int $branch_id): ?object
  {
    return $this -> repository -> find($branch_id);
  }
  
  public function getBranchProducts(int $branch_id, $data): ?object
  {
    $paginate = in_array($data['per_page'], [50, 100, 200, 500, 1000]) ? $data['per_page'] : 50;
    $branch = $this -> repository -> find($branch_id);
    $branch = $branch -> setRelation('products', $branch -> products()
    -> with('category')
    -> when($data['order_by'] && $data['order'], function($q) use($data) {
        $items_valid = ['id', 'erso_code', 'product_name', 'public_price', 'customer_price'];
        if(!in_array($data['order_by'], $items_valid) || !in_array($data['order'], ['asc', 'desc'])) return;
        $q -> orderBy($data['order_by'], $data['order']);
      })
    -> when($data['param'], function ($query_search) use($data){
      $query_search 
        -> where('erso_code', 'like', "%" . $data['param'] . "%")
        -> orwhere('product_name', 'like', "%" . $data['param'] . "%");
    })
    -> paginate($paginate));
  return $branch;
  }

}