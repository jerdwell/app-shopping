<?php

namespace Loftonti\Erso\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Loftonti\Erso\Models\CarsModels;
use Loftonti\Erso\Models\Shipowners;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Loftonti\Erso\Models\Branches;
use Loftonti\Erso\Models\Enterprises;
use Loftonti\Erso\Models\Products as ProductsModel;

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

    public function downloadLayoutStock()
    {
        try {
            $file_name = 'layout-stock.csv';
            $products = ProductsModel::all();
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$file_name",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );
            $columns = array('id', 'erso_code', utf8_decode('Cuautitlán Izcalli'), 'Tlalnepantla', 'Coacalco', utf8_decode('Precio Público'), 'Precio Cliente');
            $build = function () use ($products, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                foreach ($products as $products) {
                    $row['id'] = $products->id;
                    $row['erso_code'] = $products->erso_code;
                    $row['Cuautitlán Izcalli'] = null;
                    $row['Tlalnepantla'] = null;
                    $row['Coacalco'] = null;
                    $row['Precio Público'] = null;
                    $row['Precio Cliente'] = null;
                    fputcsv($file, array(
                        $row['id'],
                        $row['erso_code'],
                        $row['Cuautitlán Izcalli'],
                        $row['Tlalnepantla'],
                        $row['Coacalco'],
                        $row['Precio Público'],
                        $row['Precio Cliente']
                    ));
                }
                fclose($file);
            };
            return $response = response()->stream($build, 200, $headers);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function uploadFileUpdateStock(Request $request)
    {
        try {
            if (!$request->hasFile('stock_file')) throw new \Exception("Error Processing Request", 1);
            if($request -> create_stock) return $this -> createStock($request);
            $file = $request->file('stock_file');
            $file_name = Str::random(32) . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/stock_files/';
            $f = fopen($file, 'r');
            $line = 0;
            $prices = [];
            $branches = Branches::all();
            $branches = collect($branches);
            $data = [];
            while ($csvLine = fgetcsv($f, 1000, ",")) {
                if ($line > 0 && $line < 3000) {
                    if ($csvLine[0] && $csvLine[1]) {
                        if (is_numeric($csvLine[2])) {
                            $item_cuautitlan = [
                                'id' => $csvLine[0],
                                'erso_code' => $csvLine[1],
                                'branch_id' => 1,
                                'stock_branch' => $csvLine[2],
                            ];
                            array_push($data, $item_cuautitlan);
                        }
                        if (is_numeric($csvLine[3])) {
                            $item_tlalnepantla = [
                                'id' => $csvLine[0],
                                'erso_code' => $csvLine[1],
                                'branch_id' => 2,
                                'stock_branch' => $csvLine[3],
                            ];
                            array_push($data, $item_tlalnepantla);
                        }
                        if (is_numeric($csvLine[4])) {
                            $item_coacalco = [
                                'id' => $csvLine[0],
                                'erso_code' => $csvLine[1],
                                'branch_id' => 3,
                                'stock_branch' => $csvLine[4],
                            ];
                            array_push($data, $item_coacalco);
                        }
                        if ($csvLine[5] != '' || $csvLine[6] != '') {
                            if ($csvLine[5] && !$csvLine[6]) {
                                array_push($prices, ['id' => $csvLine[0], 'public_price' => $csvLine[5]]);
                            } else if (!$csvLine[5] && $csvLine[6]) {
                                array_push($prices, ['id' => $csvLine[0], 'customer_price' => $csvLine[6]]);
                            } else {
                                array_push($prices, ['id' => $csvLine[0], 'public_price' => $csvLine[5], 'customer_price' => $csvLine[6]]);
                            }
                        }
                    }
                }
                $line++;
            }
            fclose($f);
            return $this->fnUpdateStock($data, $prices);
        } catch (\Throwable $th) {
            return response()->json([$th->getMessage()], 403);
        }
    }

    public function createStock($request)
    {
        $file = $request->file('stock_file');
        $file_name = Str::random(32) . '.' . $file->getClientOriginalExtension();
        $path = 'uploads/stock_files/';
        $f = fopen($file, 'r');
        $line = 0;
        $branches = Branches::all();
        $enterprises = Enterprises::all();
        $products = ProductsModel::all();
        $products = collect($products);
        $branches = collect($branches);
        $enterprises = collect($enterprises);
        $data = [];
        $fails = [];
        while ($csvLine = fgetcsv($f, 1000, ",")) {
            if ($line > 0 && $line < 3000) {
                if ($csvLine[0] && $csvLine[1]) {
                    $erso_code = $csvLine[0];
                    $stock_sucursal = $csvLine[1];
                    $stock_sucursal = explode('/', $stock_sucursal);
                    $product_id = $products -> firstWhere('erso_code', $erso_code);
                    foreach ($stock_sucursal as $stock) {
                        $item = explode('@', $stock);
                        $branch = $branches -> firstWhere('slug', Str::slug($item[0]));
                        $enterprise = $enterprises -> firstWhere('enterprise_slug', Str::slug(utf8_encode($item[1])));
                        if($branch && $enterprise && $product_id){
                            array_push($data, [
                                'product_id' => $product_id -> id,
                                'branch_id' => $branch -> id,
                                'enterprise_id' => $enterprise -> id,
                                'stock' => $item[2],
                            ]);
                        }else{
                            $fail = [];
                            if(!$branch) array_push($fail, 'Esta sucursal no existe');
                            if(!$enterprise) array_push($fail, 'Esta empresa no existe: ' . mb_convert_encoding($item[1], 'UTF-8', 'UTF-8'));
                            if(!$product_id) array_push($fail, 'Este código no existe: ' . $erso_code);
                            array_push($fails, [
                                'erso_code' => $erso_code,
                                'branch' => utf8_encode($item[0]),
                                'enterprise' => utf8_encode($item[1]),
                                'stock' => $item[2],
                                'errors' => join(',', $fail)
                            ]);
                        }
                    }
                }
            }
            $line++;
        }
        fclose($f);
        DB::table('loftonti_erso_product_branch')
            ->insert($data);
        if(count($fails) > 0){
            Mail::send('loftonti.erso::mail.product-branch-errors', ['fails' => $fails], function($message){
                $message->to('erdwell@gmail.com', 'Sistema Erso');
                $message->subject('Errores en la creación de stock.');
            });
        }
        return [
            'updateds' => count($data),
            'items' => $data,
            'errors' => $fails
        ];
    }

    public function fnUpdateStock($data, $prices)
    {
        $updateds = 0;
        foreach ($data as $item) {
            DB::table('loftonti_erso_product_branch')
                ->where('loftonti_erso_product_branch.product_id', $item['id'])
                ->where('loftonti_erso_product_branch.branch_id', $item['branch_id'])
                ->update(['stock' => $item['stock_branch']]);
            $updateds++;
        }
        foreach ($prices as $price) {
            DB::table('loftonti_erso_products')->where('id', $price['id'])
                ->update($price);
            $updateds++;
        }
        return [
            'updateds' => $updateds,
        ];
    }

    public function downloadLayoutDeletes()
    {
        try {
            $file_name = 'layout-bajas.csv';
            $products = ProductsModel::all();
            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$file_name",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );
            $columns = array('id', 'erso_code', utf8_decode('Cuautitlán Izcalli'), 'Tlalnepantla', 'Coacalco');
            $build = function () use ($products, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                foreach ($products as $products) {
                    $row['id'] = $products->id;
                    $row['erso_code'] = $products->erso_code;
                    $row['Cuautitlán Izcalli'] = null;
                    $row['Tlalnepantla'] = null;
                    $row['Coacalco'] = null;
                    fputcsv($file, array(
                        $row['id'],
                        $row['erso_code'],
                        $row['Cuautitlán Izcalli'],
                        $row['Tlalnepantla'],
                        $row['Coacalco']
                    ));
                }
                fclose($file);
            };
            return $response = response()->stream($build, 200, $headers);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function uploadFileMassiveDelete(Request $request)
    {
        try {
            if (!$request->hasFile('delete_file')) throw new \Exception("Error Processing Request", 1);
            $file = $request->file('delete_file');
            $file_name = Str::random(32) . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/delete_files/';
            $f = fopen($file, 'r');
            $line = 0;
            $data = [];
            while ($csvLine = fgetcsv($f, 1000, ",")) {
                if ($line > 0 && $line < 3000) {
                    if ($csvLine[0] && $csvLine[1]) {
                        if ($csvLine[2]) {
                            $item_cuautitlan = [
                                'product_id' => $csvLine[0],
                                'branch_id' => 1
                            ];
                            array_push($data, $item_cuautitlan);
                        }
                        if ($csvLine[3]) {
                            $item_tlalnepantla = [
                                'product_id' => $csvLine[0],
                                'branch_id' => 2
                            ];
                            array_push($data, $item_tlalnepantla);
                        }
                        if ($csvLine[4]) {
                            $item_coacalco = [
                                'product_id' => $csvLine[0],
                                'branch_id' => 3
                            ];
                            array_push($data, $item_coacalco);
                        }
                    }
                }
                $line++;
            }
            fclose($f);
            return $this->fnMassiveDelete($data);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 403);
        }
    }

    public function fnMassiveDelete($data)
    {
        $updateds = 0;
        foreach ($data as $item) {
            DB::table('loftonti_erso_product_branch')
                ->where('product_id', $item['product_id'])
                -> where('branch_id', $item['branch_id'])
                -> delete();
            $updateds ++;       
        }
        return [
            'updateds' =>  $updateds
        ];
    }

    /**
     * get car list
     */
    public function onSearchCar()
    {
        try {
            $data_search = Input::get('car');
            $cars = CarsModels::where('car_name', 'like', "%{$data_search}%")->orderBy('car_name')->get();
            return $cars;
        } catch (\Throwable $th) {
            return response($th->getMessage(), 403);
        }
    }

    /**
     * get list shipowners
     */
    public function onSearchShipowner()
    {
        try {
            $data_search = Input::get('shipowner');
            $shipowners = Shipowners::where('shipowner_name', 'like', "%{$data_search}%")->take(20)->get();
            return $shipowners;
        } catch (\Throwable $th) {
            return response($th->getMessage(), 403);
        }
    }
}
