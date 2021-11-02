<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoProducts8 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_erso_products', function($table)
        {
            $table->integer('brand')->unsigned();
            $table->integer('category')->unsigned();
            $table->integer('shipowner')->unsigned();
            $table->dropColumn('brand_id');
            $table->dropColumn('category_id');
            $table->dropColumn('shipowner_id');
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_erso_products', function($table)
        {
            $table->dropColumn('brand');
            $table->dropColumn('category');
            $table->dropColumn('shipowner');
            $table->integer('brand_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('shipowner_id')->unsigned();
        });
    }
}
