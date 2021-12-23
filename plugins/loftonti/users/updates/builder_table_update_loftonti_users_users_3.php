<?php namespace LoftonTi\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiUsersUsers3 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_users_users', function($table)
        {
            $table->string('full_name', 150);
            $table->dateTime('email_verified_at')->nullable();
            $table->string('sk')->nullable();
            $table->string('pk')->nullable();
            $table->string('rfc')->nullable();
            $table->string('status', 5)->default('A');
            $table->string('email', 250)->change();
            $table->dropColumn('firstname');
            $table->dropColumn('lastname');
            $table->dropColumn('mail_confirm');
            $table->dropColumn('token_remember');
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_users_users', function($table)
        {
            $table->dropColumn('full_name');
            $table->dropColumn('email_verified_at');
            $table->dropColumn('sk');
            $table->dropColumn('pk');
            $table->dropColumn('rfc');
            $table->dropColumn('status');
            $table->string('email', 100)->change();
            $table->string('firstname', 150);
            $table->string('lastname', 150);
            $table->boolean('mail_confirm')->default(0);
            $table->string('token_remember', 150);
        });
    }
}
