<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoApplication2 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_erso_application', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('note', 191)->default('null')->change();
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_erso_application', function($table)
        {
            $table->dropColumn('id');
            $table->string('note', 191)->default('NULL')->change();
        });
    }
}
