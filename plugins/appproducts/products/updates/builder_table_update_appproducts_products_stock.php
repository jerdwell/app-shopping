<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsStock extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_stock', function($table)
        {
            $table->dropPrimary(['brand_details_id','branch_id']);
            $table->renameColumn('brand_details_id', 'brand_code');
            $table->primary(['brand_code','branch_id']);
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_stock', function($table)
        {
            $table->dropPrimary(['brand_code','branch_id']);
            $table->renameColumn('brand_code', 'brand_details_id');
            $table->primary(['brand_details_id','branch_id']);
        });
    }
}
