<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsPivotPCat extends Migration
{
    public function up()
    {
        Schema::rename('appproducts_products_products_categories', 'appproducts_products_pivot_p_cat');    Schema::table('appproducts_products_pivot_p_cat', function($table)
        {
            $table->primary(['product_id','category_id']);
        });
    }
    
    public function down()
    {
        Schema::rename('appproducts_products_pivot_p_cat', 'appproducts_products_products_categories');
        Schema::table('appproducts_products_products_categories', function($table)
        {
            $table->dropPrimary(['product_id','category_id']);
        });
    }
}
