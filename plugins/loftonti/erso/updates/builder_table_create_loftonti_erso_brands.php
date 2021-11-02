<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiErsoBrands extends Migration
{
    public function up()
    {
        Schema::create('loftonti_erso_brands', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('brand_name');
            $table->string('brand_slug');
            $table->string('brand_cover')->nullable();
            $table->string('brand_logo')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_erso_brands');
    }
}
