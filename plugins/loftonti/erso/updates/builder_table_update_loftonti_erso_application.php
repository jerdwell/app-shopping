<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoApplication extends Migration
{
    public function up()
    {
        Schema::table('loftonti_erso_application', function($table)
        {
            $table->string('note', 191)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_erso_application', function($table)
        {
            $table->string('note', 191)->nullable(false)->change();
        });
    }
}
