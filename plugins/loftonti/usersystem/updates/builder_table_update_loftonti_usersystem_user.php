<?php namespace LoftonTi\Usersystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiUsersystemUser extends Migration
{
    public function up()
    {
        Schema::table('loftonti_usersystem_user', function($table)
        {
            $table->renameColumn('email', 'username');
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_usersystem_user', function($table)
        {
            $table->renameColumn('username', 'email');
        });
    }
}
