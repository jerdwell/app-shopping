<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoProductStockBranch extends Migration
{
    public function up()
    {
        Schema::rename('loftonti_erso_product_branch', 'loftonti_erso_product_stock_branch');
        Schema::table('loftonti_erso_product_stock_branch', function($table)
        {
            $table->increments('id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::rename('loftonti_erso_product_stock_branch', 'loftonti_erso_product_branch');
        Schema::table('loftonti_erso_product_branch', function($table)
        {
            $table->dropColumn('id');
        });
    }
}
