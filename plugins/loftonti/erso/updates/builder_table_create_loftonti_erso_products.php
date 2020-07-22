<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiErsoProducts extends Migration
{
    public function up()
    {
        Schema::create('loftonti_erso_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('product_name');
            $table->string('product_slug');
            $table->string('product_description')->nullable();
            $table->string('product_note')->nullable();
            $table->string('product_model');
            $table->string('erso_code')->nullable();
            $table->string('provider_code');
            $table->string('product_year');
            $table->decimal('public_price', 10, 0)->nullable();
            $table->decimal('provider_price', 10, 0)->nullable();
            $table->integer('brand_id');
            $table->integer('category_id');
            $table->integer('shipowner_id');
            $table->integer('product_cover')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_erso_products');
    }
}
