<?php namespace Loftonti\Erso\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Loftonti\Erso\Models\CarsModels;
use Loftonti\Erso\Models\Shipowners;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Products extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\ImportExportController',
        'Backend.Behaviors.RelationController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';
    public $importExportConfig = 'config_import_export.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Loftonti.Erso', 'main-menu-item');
    }

    public function updateStock()
    {
        $this->addCss("/plugins/loftonti/erso/assets/css/products-import.css");
        $this->addJs("/plugins/loftonti/erso/assets/js/products-import.js");
        $arrayOfURIParams = $this->params;
    }

    public function uploadFileUpdateStock(Request $request)
    {
        try {
            if(!$request -> hasFile('stock_file')) throw new \Exception("Error Processing Request", 1);
            $file = $request -> file('stock_file');
            $file_name = Str::random(32) . '.' . $file -> getClientOriginalExtension();
            $path = 'uploads/stock_files/';
            $f = fopen($file, 'r');
            $line = 0;
            $data = [];
            while ($csvLine = fgetcsv($f,1000,",")) {
                if($line > 0 && $line < 4000){
                    $item_cuautitlan = [
                        'id' => $csvLine[0],
                        'erso_code' => $csvLine[1],
                        'branch_id' => 1,
                        'stock_branch' => $csvLine[2],
                    ];
                    $item_tlalnepantla = [
                        'id' => $csvLine[0],
                        'erso_code' => $csvLine[1],
                        'branch_id' => 2,
                        'stock_branch' => $csvLine[3],
                        'public_price' => $csvLine[5],
                        'customer_price' => $csvLine[6],
                    ];
                    $item_coacalco = [
                        'id' => $csvLine[0],
                        'erso_code' => $csvLine[1],
                        'branch_id' => 3,
                        'stock_branch' => $csvLine[4],
                        'public_price' => $csvLine[5],
                        'customer_price' => $csvLine[6],
                    ];
                    if($csvLine[5] != '') $item_cuautitlan['public_price'] = $csvLine[5];
                    if($csvLine[6] != '') $item_cuautitlan['customer_price'] = $csvLine[6];
                    if($csvLine[5] != '') $item_tlalnepantla['public_price'] = $csvLine[5];
                    if($csvLine[6] != '') $item_tlalnepantla['customer_price'] = $csvLine[6];
                    if($csvLine[5] != '') $item_coacalco['public_price'] = $csvLine[5];
                    if($csvLine[6] != '') $item_coacalco['customer_price'] = $csvLine[6];
                    array_push($data, $item_cuautitlan);
                    array_push($data, $item_tlalnepantla);
                    array_push($data, $item_coacalco);
                }
                $line ++;
            }
            fclose($f);
            return $this -> fnUpdateStock($data);
        } catch (\Throwable $th) {
            return response() -> json([$th -> getMessage()], 403);
        }
    }

    public function fnUpdateStock($data)
    {
        $updateds = 0;
        foreach ($data as $item) {
            DB::table('loftonti_erso_product_branch')
                ->where('loftonti_erso_product_branch.product_id', $item['id'])
                ->where('loftonti_erso_product_branch.branch_id', $item['branch_id'])
                ->update(['stock' => $item['stock_branch']]);
            if(isset($item['public_price']) && isset($item['customer_price']) && $item['public_price'] && $item['customer_price']){
                DB::table('loftonti_erso_products') -> where('id', $item['id'])
                    -> update(['public_price' => $item['public_price'], 'customer_price' => $item['customer_price']]);
            }
            $updateds ++;
        }
        return [
            'updateds' => $updateds,
        ];
    }

    /**
     * get car list
     */
    public function onSearchCar()
    {
        try {
            $data_search = Input::get('car');
            $cars = CarsModels::where('car_name', 'like', "%{$data_search}%") -> take(20) -> get();
            return $cars;
        } catch (\Throwable $th) {
            return response($th -> getMessage(), 403);
        }
    }

    /**
     * get list shipowners
     */
    public function onSearchShipowner()
    {
        try {
            $data_search = Input::get('shipowner');
            $shipowners = Shipowners::where('shipowner_name', 'like', "%{$data_search}%") -> take(20) -> get();
            return $shipowners;
        } catch (\Throwable $th) {
            return response($th -> getMessage(), 403);
        }
    }
}
