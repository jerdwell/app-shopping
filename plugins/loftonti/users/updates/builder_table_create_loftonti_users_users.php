<?php namespace LoftonTi\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiUsersUsers extends Migration
{
    public function up()
    {
        Schema::create('loftonti_users_users', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('firstname', 150);
            $table->string('lastname', 150);
            $table->string('email', 100);
            $table->string('phone', 30);
            $table->string('password', 150);
            $table->boolean('mail_confirm')->default(false);
            $table->string('token_remember', 150);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_users_users');
    }
}
