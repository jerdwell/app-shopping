<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsBrands2 extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_brands', function($table)
        {
            $table->string('brand_cover')->nullable();
            $table->string('brand_logo')->nullable();
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_brands', function($table)
        {
            $table->dropColumn('brand_cover');
            $table->dropColumn('brand_logo');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
}
