<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoProductBranch3 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_erso_product_branch', function($table)
        {
            $table->dropColumn('id');
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_erso_product_branch', function($table)
        {
            $table->increments('id')->unsigned();
        });
    }
}
