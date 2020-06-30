<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAppproductsProductsStock extends Migration
{
    public function up()
    {
        Schema::create('appproducts_products_stock', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('brand_details_id');
            $table->integer('branch_id');
            $table->integer('stock_product');
            $table->primary(['brand_details_id','branch_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('appproducts_products_stock');
    }
}
