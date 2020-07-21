<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsCategories4 extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_categories', function($table)
        {
            $table->string('category_cover')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_categories', function($table)
        {
            $table->dropColumn('category_cover');
        });
    }
}
