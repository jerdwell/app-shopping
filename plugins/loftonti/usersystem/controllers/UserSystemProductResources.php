<?php 
namespace LoftonTI\Usersystem\Controllers;

use Illuminate\Http\Request;
use LoftonTi\Usersystem\Classes\UseCases\Branches\AttachProductUseCase;
use LoftonTI\Usersystem\Classes\UseCases\Products\CreateProductUseCase;

class UserSystemProductResources
{
  /**
   * @var string
   */
  private $public_price, $customer_price;
  /**
   * @var array
   */
  private $applications;

  public function createProductController(Request $request)
  {
    try {
      $this -> setApplications($request -> applications);
      $this -> setPrices($request -> all());
      $use_case = new CreateProductUseCase(
        $request -> CVE_ART,
        $request -> CVES_ALTER,
        $request -> DESCR,
        $request -> category['id'],
        $request -> brand['id'],
        $this -> public_price,
        $this -> customer_price,
        $request -> CVE_IMAGEN,
        $this -> applications
      );
      $product = $use_case();
      $attach_branch = new AttachProductUseCase(
        $request -> branch_id,
        $request -> enterprise_id,
        intval($request -> EXIST),
        $product
      );
      $attach_branch();
      return $product;
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ]);
    }
  }

  /**
   * @method setApplications
   * @param Array $applications
   * @return void
   */
  private function setApplications(array $applications)
  {
    $items = array();
    try {
      foreach($applications as $application) {
        $items[] = [
          'car_id' => $application['car']['id'],
          'shipowner_id' => $application['shipowner']['id'],
          'year' => $application['years']['from'] . '-' . $application['years']['to'],
          'note' => $application['notes']
        ];
      }
      $this -> applications = $items;
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * Set ptoduct prices [public_price, customer_price]
   * @method setPrices
   * @param Array $product
   * @return void
   */
  private function setPrices($product):void
  {
    try {
      if(count($product['prices']) <= 0){
        $this -> public_price = $product['ULT_COSTO'];
        $this -> customer_price = $product['ULT_COSTO'];
      }else{
        $public_price = collect($product['prices']) -> firstWhere('CVE_PRECIO', '=', 1);
        $customer_price = collect($product['prices']) -> firstWhere('CVE_PRECIO', '=', 2);
        $this -> public_price = $public_price ? $public_price['PRECIO'] : $product['ULT_COSTO'];
        $this -> customer_price = $customer_price ? $customer_price['PRECIO'] : $product['ULT_COSTO'];
      }
    } catch (\Throwable $th) {
      throw $th;
    }
  }

}