<?php namespace Loftonti\Erso\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiErsoProductBranch extends Migration
{
    public function up()
    {
        Schema::create('loftonti_erso_product_branch', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('product_id')->unsigned();
            $table->integer('branch_id')->unsigned();
            $table->integer('stock')->default(100);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_erso_product_branch');
    }
}
