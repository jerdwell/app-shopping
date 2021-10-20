<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoBranches2 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_erso_branches', function($table)
        {
            $table->string('rfc')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_erso_branches', function($table)
        {
            $table->dropColumn('rfc');
        });
    }
}
