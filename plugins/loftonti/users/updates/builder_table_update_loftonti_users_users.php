<?php namespace LoftonTi\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiUsersUsers extends Migration
{
    public function up()
    {
        Schema::table('loftonti_users_users', function($table)
        {
            $table->string('type', 150)->default('user');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->dropColumn('deleted_at');
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_users_users', function($table)
        {
            $table->dropColumn('type');
            $table->timestamp('created_at')->nullable()->default('NULL');
            $table->timestamp('updated_at')->nullable()->default('NULL');
            $table->timestamp('deleted_at')->nullable()->default('NULL');
        });
    }
}
