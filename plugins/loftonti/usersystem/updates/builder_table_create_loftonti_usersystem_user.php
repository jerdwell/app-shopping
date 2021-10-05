<?php namespace LoftonTi\Usersystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiUsersystemUser extends Migration
{
    public function up()
    {
        Schema::create('loftonti_usersystem_user', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->string('password');
            $table->string('sk');
            $table->string('pk');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('rol_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_usersystem_user');
    }
}
