<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteAppproductsProductsBrandsDetails extends Migration
{
    public function up()
    {
        Schema::dropIfExists('appproducts_products_brands_details');
    }
    
    public function down()
    {
        Schema::create('appproducts_products_brands_details', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('brand_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->string('brand_code', 191)->nullable();
            $table->integer('brand_price')->nullable()->unsigned();
            $table->integer('brand_public_price')->nullable()->unsigned();
            $table->string('brand_remark', 191)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->primary(['brand_id','product_id']);
        });
    }
}
