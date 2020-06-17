<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsCategories extends Migration
{
    public function up()
    {
        Schema::rename('appproducts_products_', 'appproducts_products_categories');
    }
    
    public function down()
    {
        Schema::rename('appproducts_products_categories', 'appproducts_products_');
    }
}
