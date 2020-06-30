<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsStockBranch extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_stock_branch', function($table)
        {
            $table->renameColumn('brand_code', 'brand__detail_id');
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_stock_branch', function($table)
        {
            $table->renameColumn('brand__detail_id', 'brand_code');
        });
    }
}
