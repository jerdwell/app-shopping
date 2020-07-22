<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiErsoShipowners extends Migration
{
    public function up()
    {
        Schema::create('loftonti_erso_shipowners', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('shipowner_name');
            $table->string('shipowner_slug');
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_erso_shipowners');
    }
}
