<?php namespace LoftonTi\Usersystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiUsersystemActivitiesUser extends Migration
{
    public function up()
    {
        Schema::create('loftonti_usersystem_activities_user', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id');
            $table->string('type');
            $table->text('request');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->time('response');
            $table->integer('response_code')->default(200);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_usersystem_activities_user');
    }
}
