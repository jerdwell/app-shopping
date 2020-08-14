<?php namespace LoftonTi\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiUsersAddress extends Migration
{
    public function up()
    {
        Schema::create('loftonti_users_address', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('address1', 150);
            $table->string('suburb', 150);
            $table->string('country', 150);
            $table->string('state', 150);
            $table->string('city', 150);
            $table->string('zip_code');
            $table->string('address2', 150)->nullable();
            $table->integer('user_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_users_address');
    }
}
