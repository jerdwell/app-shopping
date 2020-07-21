<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsProducts15 extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_products', function($table)
        {
            $table->string('product_cover')->nullable();
            $table->text('product_description')->nullable()->change();
            $table->string('product_note', 191)->nullable()->change();
            $table->string('erso_code', 191)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_products', function($table)
        {
            $table->dropColumn('product_cover');
            $table->text('product_description')->nullable(false)->change();
            $table->string('product_note', 191)->nullable(false)->change();
            $table->string('erso_code', 191)->nullable(false)->change();
        });
    }
}
