<?php namespace LoftonTi\Usersystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiUsersystemRoles extends Migration
{
    public function up()
    {
        Schema::table('loftonti_usersystem_roles', function($table)
        {
            $table->string('slug');
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_usersystem_roles', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}
