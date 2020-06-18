<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAppproductsProductsTags extends Migration
{
    public function up()
    {
        Schema::create('appproducts_products_tags', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('tag_name', 150);
            $table->string('slug', 150);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('appproducts_products_tags');
    }
}
