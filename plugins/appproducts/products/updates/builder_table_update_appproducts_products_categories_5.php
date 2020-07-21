<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsCategories5 extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_categories', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_categories', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
}
