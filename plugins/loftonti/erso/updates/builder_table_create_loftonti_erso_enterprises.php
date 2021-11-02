<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiErsoEnterprises extends Migration
{
    public function up()
    {
        Schema::create('loftonti_erso_enterprises', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('enterprise_name');
            $table->string('enterprise_slug');
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_erso_enterprises');
    }
}
