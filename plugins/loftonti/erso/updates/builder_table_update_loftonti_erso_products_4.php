<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoProducts4 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_erso_products', function($table)
        {
            $table->dropColumn('brand_id');
            $table->dropColumn('category_id');
            $table->dropColumn('shipowner_id');
            $table->dropColumn('enterprise_id');
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_erso_products', function($table)
        {
            $table->integer('brand_id');
            $table->integer('category_id');
            $table->integer('shipowner_id');
            $table->integer('enterprise_id');
        });
    }
}
