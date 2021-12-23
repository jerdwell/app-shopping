<?php namespace LoftonTi\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiUsersAddress extends Migration
{
    public function up()
    {
        Schema::table('loftonti_users_address', function($table)
        {
            $table->string('line3')->nullable();
            $table->string('localty')->nullable();
            $table->string('cross_site1')->nullable();
            $table->string('cross_site2')->nullable();
            $table->string('referency')->nullable();
            $table->renameColumn('address1', 'line1');
            $table->renameColumn('address2', 'line2');
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_users_address', function($table)
        {
            $table->dropColumn('line3');
            $table->dropColumn('localty');
            $table->dropColumn('cross_site1');
            $table->dropColumn('cross_site2');
            $table->dropColumn('referency');
            $table->renameColumn('line1', 'address1');
            $table->renameColumn('line2', 'address2');
        });
    }
}
