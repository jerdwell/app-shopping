<?php namespace AppProducts\Products\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAppproductsProductsBrandsDetails extends Migration
{
    public function up()
    {
        Schema::create('appproducts_products_brands_details', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('brand_code')->nullable();
            $table->integer('brand_price')->nullable()->unsigned();
            $table->integer('brand_public_price')->nullable()->unsigned();
            $table->string('brand_remark')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('brand_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('appproducts_products_brands_details');
    }
}
