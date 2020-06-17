<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteAppproductsProductsProductsCategories extends Migration
{
    public function up()
    {
        Schema::dropIfExists('appproducts_products_products_categories');
    }
    
    public function down()
    {
        Schema::create('appproducts_products_products_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('product_id');
            $table->integer('category_id');
        });
    }
}
