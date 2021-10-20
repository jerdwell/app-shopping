<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoEnterprises extends Migration
{
    public function up()
    {
        Schema::table('loftonti_erso_enterprises', function($table)
        {
            $table->string('rfc')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_erso_enterprises', function($table)
        {
            $table->dropColumn('rfc');
        });
    }
}
