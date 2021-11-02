<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoProducts11 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_erso_products', function($table)
        {
            $table->integer('model_id')->nullable()->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_erso_products', function($table)
        {
            $table->dropColumn('model_id');
        });
    }
}
