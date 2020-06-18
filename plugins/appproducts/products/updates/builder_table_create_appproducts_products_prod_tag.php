<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAppproductsProductsProdTag extends Migration
{
    public function up()
    {
        Schema::create('appproducts_products_prod_tag', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('id_product');
            $table->integer('id_tag');
            $table->primary(['id_product','id_tag']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('appproducts_products_prod_tag');
    }
}
