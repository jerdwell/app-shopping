<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiErsoBranches extends Migration
{
    public function up()
    {
        Schema::create('loftonti_erso_branches', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('branch_name');
            $table->string('address1');
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('zip_code');
            $table->string('country');
            $table->text('contact_data')->nullable();
            $table->string('state');
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_erso_branches');
    }
}
