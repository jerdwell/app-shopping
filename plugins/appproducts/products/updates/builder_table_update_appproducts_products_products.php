<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsProducts extends Migration
{
    public function up()
    {
        Schema::rename('appproducts_products_', 'appproducts_products_products');
    }
    
    public function down()
    {
        Schema::rename('appproducts_products_products', 'appproducts_products_');
    }
}
