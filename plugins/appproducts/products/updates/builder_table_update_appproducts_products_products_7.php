<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsProducts7 extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_products', function($table)
        {
            $table->dropColumn('product_metadata');
            $table->dropColumn('product_price');
            $table->dropColumn('product_sku');
            $table->dropColumn('product_stock');
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_products', function($table)
        {
            $table->text('product_metadata')->nullable();
            $table->integer('product_price')->unsigned();
            $table->string('product_sku', 150);
            $table->integer('product_stock')->unsigned();
        });
    }
}
