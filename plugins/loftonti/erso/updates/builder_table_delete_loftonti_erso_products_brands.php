<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteLoftontiErsoProductsBrands extends Migration
{
    public function up()
    {
        Schema::dropIfExists('loftonti_erso_products_brands');
    }
    
    public function down()
    {
        Schema::create('loftonti_erso_products_brands', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('product_id');
            $table->integer('brand_id');
            $table->primary(['product_id','brand_id']);
        });
    }
}
