<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiErsoApplication extends Migration
{
    public function up()
    {
        Schema::create('loftonti_erso_application', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('product_id')->unsigned();
            $table->integer('car_id');
            $table->integer('shipowner_id');
            $table->string('year');
            $table->string('note');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_erso_application');
    }
}
