<?php namespace Loftonti\Erso\Models;

use Backend\Models\ImportModel;
use Loftonti\Erso\Models\{Categories, Products, Shipowners, Enterprises, Brands, CarsModels};
use Illuminate\Support\Str;

class ProductsImport extends ImportModel
{

  public $rules = [];
  
  public function importdata($results, $sessionKey = null)
  {
    $imgSrc = '/products/placeholder-img.png';
    
    $shipowners = new Shipowners;
    $categories = new Categories;
    $enterprises = new Enterprises;
    $brands = new Brands;
    $carsmodels = new CarsModels;
    foreach ($results as $row => $data) {
      
      try {
      
        $shipowner = $shipowners -> where('shipowner_slug', Str::slug($data['shipowner_id']))  -> first();
        $category = $categories -> where('category_slug', Str::slug($data['category_id'])) -> first();
        $enterprise = $enterprises -> where('enterprise_slug', Str::slug($data['enterprise_id'])) -> first();
        $brand = $brands -> where('brand_slug', Str::slug($data['brand_id'])) -> first();
        $carmodel = $carsmodels -> where('model_slug', Str::slug($data['product_model'])) -> first();

        if(!isset($shipowner -> id)) throw new \Exception("Armadora {$data['shipowner_id']} no encontrada");
        if(!isset($brand -> id)) throw new \Exception("Marca {$data['brand_id']} no encontrada");
        if(!isset($category -> id)) throw new \Exception("Categoría {$data['category_id']} no encontrada");
        if(!isset($enterprise -> id)) throw new \Exception("Empresa {$data['enterprise_id']} no encontrada");
        if(!isset($carmodel -> id)) throw new \Exception("Modelo {$data['product_model']} no encontrado");

        $product = new Products;
        $product -> shipowner_id = $shipowner -> id;
        $product -> erso_code = $data['erso_code'];
        $product -> provider_code = $data['provider_code'];
        $product -> product_year = $data['product_year'];
        $product -> product_name = $data['product_name'];
        $product -> product_slug = Str::slug($data['product_name']);
        $product -> product_description = $data['product_description'];
        $product -> product_note = $data['product_note'];
        $product -> category_id = $category -> id;
        $product -> enterprise_id = $enterprise -> id;
        $product -> brand_id = $brand -> id;
        $product -> public_price = $data['public_price'];
        $product -> provider_price = $data['provider_price'];
        $product -> model_id = $carmodel -> id;
        $product -> product_cover = $imgSrc;

        $product -> save();

        $this -> logCreated();

      } catch (\Exception $ex) {
        $this->logError($row, $ex -> getMessage());
      }
    }
    
  }

}