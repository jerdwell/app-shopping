<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsStock3 extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_stock', function($table)
        {
            $table->string('brand_code', 150)->change();
            $table->primary(['branch_id','product_id']);
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_stock', function($table)
        {
            $table->dropPrimary(['branch_id','product_id']);
            $table->string('brand_code', 10)->change();
        });
    }
}
