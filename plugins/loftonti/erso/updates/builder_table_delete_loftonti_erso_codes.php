<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteLoftontiErsoCodes extends Migration
{
    public function up()
    {
        Schema::dropIfExists('loftonti_erso_codes');
    }
    
    public function down()
    {
        Schema::create('loftonti_erso_codes', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('erso_code', 191);
            $table->timestamp('deleted_at')->nullable()->default('NULL');
        });
    }
}
