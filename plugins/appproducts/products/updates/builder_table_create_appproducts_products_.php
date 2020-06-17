<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAppproductsProducts extends Migration
{
    public function up()
    {
        Schema::create('appproducts_products_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('product_id');
            $table->string('product_name', 150);
            $table->text('product_description')->nullable();
            $table->text('product_metadata')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('product_price')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('appproducts_products_');
    }
}
