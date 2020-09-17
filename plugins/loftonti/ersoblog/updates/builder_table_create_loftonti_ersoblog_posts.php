<?php namespace LoftonTi\ErsoBlog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiErsoblogPosts extends Migration
{
    public function up()
    {
        Schema::create('loftonti_ersoblog_posts', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('type');
            $table->string('title');
            $table->text('content');
            $table->string('status');
            $table->string('slug');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_ersoblog_posts');
    }
}
