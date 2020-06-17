<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsProductsCategories extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_products_categories', function($table)
        {
            $table->integer('product_id')->unsigned(false)->change();
            $table->integer('category_id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_products_categories', function($table)
        {
            $table->integer('product_id')->unsigned()->change();
            $table->integer('category_id')->unsigned()->change();
            $table->primary(['product_id', 'category_id']);
        });
    }
}
