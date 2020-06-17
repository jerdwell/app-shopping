<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsProducts5 extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_products', function($table)
        {
            $table->increments('product_id')->nullable(false)->unsigned()->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_products', function($table)
        {
            $table->bigIncrements('product_id')->nullable(false)->unsigned()->default(null)->change();
        });
    }
}
