<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoProductBranch extends Migration
{
    public function up()
    {
        Schema::table('loftonti_erso_product_branch', function($table)
        {
            $table->integer('enterprise_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_erso_product_branch', function($table)
        {
            $table->dropColumn('enterprise_id');
        });
    }
}
