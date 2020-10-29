<?php namespace LoftonTi\Components\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiComponentsSlide extends Migration
{
    public function up()
    {
        Schema::table('loftonti_components_slide', function($table)
        {
            $table->string('slide_text', 191)->default('null')->change();
            $table->string('slide_landscape', 191)->default(null)->change();
            $table->string('slide_portrait', 191)->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_components_slide', function($table)
        {
            $table->string('slide_text', 191)->default(null)->change();
            $table->string('slide_landscape', 191)->default('NULL')->change();
            $table->string('slide_portrait', 191)->default('NULL')->change();
        });
    }
}
