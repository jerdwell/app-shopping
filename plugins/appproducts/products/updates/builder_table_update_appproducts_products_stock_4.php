<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsStock4 extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_stock', function($table)
        {
            $table->dropPrimary(['branch_id','product_id']);
            $table->primary(['product_id']);
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_stock', function($table)
        {
            $table->dropPrimary(['product_id']);
            $table->primary(['branch_id','product_id']);
        });
    }
}
