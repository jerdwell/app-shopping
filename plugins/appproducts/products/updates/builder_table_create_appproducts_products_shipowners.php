<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAppproductsProductsShipowners extends Migration
{
    public function up()
    {
        Schema::create('appproducts_products_shipowners', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('shipowner_name');
            $table->string('shipowner_slug');
            $table->string('shipowner_logo')->nullable();
            $table->string('shipowner_cover')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('appproducts_products_shipowners');
    }
}
