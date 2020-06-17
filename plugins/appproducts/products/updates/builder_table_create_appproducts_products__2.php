<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAppproductsProducts2 extends Migration
{
    public function up()
    {
        Schema::create('appproducts_products_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('category', 150);
            $table->string('slug', 150);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('appproducts_products_');
    }
}
