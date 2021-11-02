<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoProducts14 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_erso_products', function($table)
        {
            $table->renameColumn('erso_code', 'erso_code_id');
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_erso_products', function($table)
        {
            $table->renameColumn('erso_code_id', 'erso_code');
        });
    }
}
