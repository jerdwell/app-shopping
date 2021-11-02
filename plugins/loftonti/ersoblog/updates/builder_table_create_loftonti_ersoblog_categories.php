<?php namespace LoftonTi\ErsoBlog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiErsoblogCategories extends Migration
{
    public function up()
    {
        Schema::create('loftonti_ersoblog_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->boolean('status')->default(true);
            $table->string('description')->nullable();
            $table->string('slug');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_ersoblog_categories');
    }
}
