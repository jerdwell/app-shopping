<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoProducts10 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_erso_products', function($table)
        {
            $table->integer('enterprise_id')->nullable()->unsigned();
            $table->integer('brand_id')->nullable()->change();
            $table->integer('category_id')->nullable()->change();
            $table->integer('shipowner_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_erso_products', function($table)
        {
            $table->dropColumn('enterprise_id');
            $table->integer('brand_id')->nullable(false)->change();
            $table->integer('category_id')->nullable(false)->change();
            $table->integer('shipowner_id')->nullable(false)->change();
        });
    }
}
