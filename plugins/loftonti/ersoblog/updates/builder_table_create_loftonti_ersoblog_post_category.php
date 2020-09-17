<?php namespace LoftonTi\ErsoBlog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiErsoblogPostCategory extends Migration
{
    public function up()
    {
        Schema::create('loftonti_ersoblog_post_category', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('post_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->primary(['post_id','category_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_ersoblog_post_category');
    }
}
