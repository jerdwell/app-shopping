<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoBranches extends Migration
{
    public function up()
    {
        Schema::table('loftonti_erso_branches', function($table)
        {
            $table->string('slug');
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_erso_branches', function($table)
        {
            $table->dropColumn('slug');
        });
    }
}
