<?php

namespace LoftonTi\Usersystem\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use loftonTi\Usersystem\Classes\UseCases\Products\CreateCarUseCase;
use LoftonTi\Usersystem\Classes\UseCases\Products\CreateShipownerUseCase;
use LoftonTi\Usersystem\Classes\UseCases\Products\GetBrandsUseCase;
use LoftonTi\Usersystem\Classes\UseCases\Products\GetCarsUseCase;
use LoftonTi\Usersystem\Classes\UseCases\Products\GetCategoriesUseCase;
use LoftonTi\Usersystem\Classes\UseCases\Products\GetDasboardDataUseCase;
use LoftonTi\Usersystem\Classes\UseCases\Products\GetShipownersUseCase;
use LoftonTI\Usersystem\Classes\UseCases\Products\SearchBrandsUseCase;
use LoftonTI\Usersystem\Classes\UseCases\Products\SearchCarsUseCase;
use LoftonTI\Usersystem\Classes\UseCases\Products\SearchShipownerUseCase;

class UserSystemProductsHandler  
{

  /**
   * @method get data dashboard
   */
  public function dashboardData(Request $request)
  {
    try {
      $dashboard = new GetDasboardDataUseCase($request -> branch_id);
      return $dashboard();
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ], 403);
    }
  }

  /**
   * @method
   */
  public function uploadFileSync(Request $request)
  {
    try {
      if(!$request -> hasFile('file_sync')) throw new \Exception("No  existe un archivo cargado");
      $file = $request -> file('file_sync');
      if($file -> getClientOriginalExtension() != 'csv') throw new \Exception("El archivo que intentas cargar no es de tipo .csv");
      $file_name = explode('.', $file -> hashName())[0] . '.csv';
      Storage::putFileAs('private/sync-files/branch/' . $request -> branch_id, $file, $file_name);
      Queue::push('LoftonTi\Usersystem\Classes\UseCases\Products\PrepareProductsToSyncDatabaseUseCase', [
        'branch_id' => $request -> branch_id,
        'file_name' => $file_name
      ]);
      return response() -> json([
        'message' => 'El archivo se ha cargado exitosamente, te notificaremos por correo cuando se haya procesado la información.'
      ], 200);
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ], 400);
    }
  }

  /**
   * search brands
   * @method
   */
  public function searchBrands(Request $request)
  {
    try {
      if(!$request -> has('data_search')) throw new \Exception("Es importante colocar el parámetro de búsqueda");
      $brands = new SearchBrandsUseCase($request -> data_search);
      return $brands -> searchByParam();
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ], 400);
    }
  }

  /**
   * @method getBranches
   */
  public function getBrands(Request $request)
  {
    try {
      $brands = new GetBrandsUseCase;
      return $brands();
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ], 401);
    }
  }
  
  /**
   * search categories
   * @method
   */
  public function getCategories()
  {
    try {
      $use_case = new GetCategoriesUseCase();
      return $use_case();
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ], 400);
    }
  }

  /**
   * create new car
   * @method
   */
  public function createCar(Request $request)
  {
    try {
      if(!$request -> has('car_name')) throw new \Exception("Es importante colocar el parámetro de búsqueda");
      $created = new CreateCarUseCase($request -> car_name);
      return $created();
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ], 400);
    }
  }

  /**
   * get all cars
   * @method
   */
  public function getCars()
  {
    try {
      $cars = new GetCarsUseCase;
      return $cars -> get();
    } catch (\Throwable $th) {
      throw $th;
    }
  }

  /**
   * Search car
   * @method
   */
  public function searchCars(Request $request)
  {
    try {
      if(!$request -> has('data_search')) throw new \Exception("Es importante colocar el parámetro de búsqueda");
      $search = new SearchCarsUseCase($request -> data_search);
      return $search -> searchByParam();
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ], 400);
    }
  }

  /**
   * create new shipowner
   * @method
   */
  public function createShipowner(Request $request)
  {
    try {
      if(!$request -> has('shipowner_name')) throw new \Exception("Es importante colocar el parámetro de búsqueda");
      $created = new CreateShipownerUseCase($request -> shipowner_name);
      return $created();
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ], 400);
    }
  }

  /**
   * Search shipowner
   * @method
   */
  public function searchShipowners(Request $request)
  {
    try {
      if(!$request -> has('data_search')) throw new \Exception("Es importante colocar el parámetro de búsqueda");
      $shipowner = new SearchShipownerUseCase($request -> data_search);
      return $shipowner -> searchByParam();
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ], 400);
    }
  }

  /**
   * Get all cars and shipowners
   * @method
   */
  public function getCarsAndShipowners(Request $request)
  {
    try {
      $brands = new GetBrandsUseCase();
      $cars = new GetCarsUseCase;
      $shipowners = new GetShipownersUseCase;
      $categories = new GetCategoriesUseCase;
      return [
        'cars' => $cars -> get(),
        'shipowners' => $shipowners -> get(),
        'brands' => $brands(),
        'categories' => $categories()
      ];
      return $request -> all();
    } catch (\Throwable $th) {
      return response() -> json([
        'error' => $th -> getMessage()
      ], 400);
    }
  }
  
}
