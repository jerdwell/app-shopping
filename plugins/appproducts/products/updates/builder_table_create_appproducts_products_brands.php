<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAppproductsProductsBrands extends Migration
{
    public function up()
    {
        Schema::create('appproducts_products_brands', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('brand_name');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('appproducts_products_brands');
    }
}
