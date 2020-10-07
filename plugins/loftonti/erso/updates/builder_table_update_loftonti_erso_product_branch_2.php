<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiErsoProductBranch2 extends Migration
{
    public function up()
    {
        Schema::rename('loftonti_erso_product_stock_branch', 'loftonti_erso_product_branch');
    }
    
    public function down()
    {
        Schema::rename('loftonti_erso_product_branch', 'loftonti_erso_product_stock_branch');
    }
}
