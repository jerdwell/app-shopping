<?php namespace LoftonTi\Usersystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiUsersystemUserBranches extends Migration
{
    public function up()
    {
        Schema::create('loftonti_usersystem_user_branches', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id');
            $table->integer('branch_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_usersystem_user_branches');
    }
}
