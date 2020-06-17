<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsProducts3 extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_products', function($table)
        {
            $table->integer('product_stock')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_products', function($table)
        {
            $table->dropColumn('product_stock');
        });
    }
}
