<?php namespace Loftonti\Quotations\Models;

use Illuminate\Support\Facades\App;
use Model;
use Barryvdh\DomPDF\Facade as PDF;

class QuotationsConstructor extends Model
{

  public static function buildQuotation($quotation, $branch, $view)
  {
    $data_quotation = [
      'data_quotation' => $quotation,
      'data_branch' => $branch,
      'logo' => base_path() . '/themes/erso/assets/img/brand/brand_logo_erso_white.png'
    ];
    $pdf = PDF::loadView('loftonti.quotations::pdf.quotation', $data_quotation);
    if($view == 'download'){
      return $pdf -> download('quotation_' . date('YmdHis') . '.pdf');
    }else{
      return $pdf -> stream('quotation_' . date('YmdHis') . '.pdf');
    }
  }

}