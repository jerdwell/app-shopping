<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsCategories3 extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_categories', function($table)
        {
            $table->string('category_name', 150);
            $table->string('category_slug', 150);
            $table->dropColumn('category');
            $table->dropColumn('slug');
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_categories', function($table)
        {
            $table->dropColumn('category_name');
            $table->dropColumn('category_slug');
            $table->string('category', 150);
            $table->string('slug', 150);
        });
    }
}
