<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsBrands extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_brands', function($table)
        {
            $table->string('brand_slug');
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_brands', function($table)
        {
            $table->dropColumn('brand_slug');
        });
    }
}
