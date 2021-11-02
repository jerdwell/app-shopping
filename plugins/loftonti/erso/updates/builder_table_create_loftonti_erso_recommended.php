<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiErsoRecommended extends Migration
{
    public function up()
    {
        Schema::create('loftonti_erso_recommended', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->boolean('status')->default(true);
            $table->text('items');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_erso_recommended');
    }
}
