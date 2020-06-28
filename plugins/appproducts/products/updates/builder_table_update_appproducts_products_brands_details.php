<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppproductsProductsBrandsDetails extends Migration
{
    public function up()
    {
        Schema::table('appproducts_products_brands_details', function($table)
        {
            $table->integer('product_id')->unsigned();
            $table->dropColumn('id');
            $table->primary(['brand_id','product_id']);
        });
    }
    
    public function down()
    {
        Schema::table('appproducts_products_brands_details', function($table)
        {
            $table->dropPrimary(['brand_id','product_id']);
            $table->dropColumn('product_id');
            $table->increments('id')->unsigned();
        });
    }
}
