<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsProducts6 extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_products', function($table)
        {
            $table->renameColumn('product_id', 'id');
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_products', function($table)
        {
            $table->renameColumn('id', 'product_id');
        });
    }
}
