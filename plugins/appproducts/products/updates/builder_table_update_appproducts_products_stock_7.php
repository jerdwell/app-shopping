<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsStock7 extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_stock', function($table)
        {
            $table->dropColumn('id');
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_stock', function($table)
        {
            $table->increments('id')->unsigned();
        });
    }
}
