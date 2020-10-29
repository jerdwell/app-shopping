<?php namespace LoftonTi\Components\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiComponentsSlide extends Migration
{
    public function up()
    {
        Schema::create('loftonti_components_slide', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('slide_text');
            $table->boolean('status');
            $table->string('slide_landscape')->nullable();
            $table->string('slide_portrait')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_components_slide');
    }
}
