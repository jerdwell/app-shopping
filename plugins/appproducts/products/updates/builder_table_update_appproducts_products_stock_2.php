<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsStock2 extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_stock', function($table)
        {
            $table->string('brand_code', 10)->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_stock', function($table)
        {
            $table->integer('brand_code')->nullable(false)->unsigned(false)->default(null)->change();
        });
    }
}
