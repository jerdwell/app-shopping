<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoCars2 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_erso_cars', function($table)
        {
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_erso_cars', function($table)
        {
            $table->dropColumn('deleted_at');
        });
    }
}
