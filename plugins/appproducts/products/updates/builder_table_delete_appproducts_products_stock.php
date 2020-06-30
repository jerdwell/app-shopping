<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteAppproductsProductsStock extends Migration
{
    public function up()
    {
        Schema::dropIfExists('appproducts_products_stock');
    }
    
    public function down()
    {
        Schema::create('appproducts_products_stock', function($table)
        {
            $table->engine = 'InnoDB';
            $table->string('brand_code', 150);
            $table->integer('branch_id')->unsigned();
            $table->integer('stock_product');
            $table->integer('product_id')->unsigned();
        });
    }
}
