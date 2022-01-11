<?php namespace LoftonTi\Users\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiUsersAddress2 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_users_address', function($table)
        {
            $table->string('line1', 150)->nullable()->change();
            $table->string('suburb', 150)->nullable()->change();
            $table->string('country', 150)->nullable()->change();
            $table->string('state', 150)->nullable()->change();
            $table->string('city', 150)->nullable()->change();
            $table->string('zip_code', 191)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_users_address', function($table)
        {
            $table->string('line1', 150)->nullable(false)->change();
            $table->string('suburb', 150)->nullable(false)->change();
            $table->string('country', 150)->nullable(false)->change();
            $table->string('state', 150)->nullable(false)->change();
            $table->string('city', 150)->nullable(false)->change();
            $table->string('zip_code', 191)->nullable(false)->change();
        });
    }
}
