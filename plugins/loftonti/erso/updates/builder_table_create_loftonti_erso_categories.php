<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiErsoCategories extends Migration
{
    public function up()
    {
        Schema::create('loftonti_erso_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('category_name');
            $table->string('category_slug');
            $table->string('category_cover')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_erso_categories');
    }
}
