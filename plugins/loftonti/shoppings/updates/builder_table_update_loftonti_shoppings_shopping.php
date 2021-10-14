<?php namespace LoftonTi\Shoppings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiShoppingsShopping extends Migration
{
    public function up()
    {
        Schema::table('loftonti_shoppings_shopping', function($table)
        {
            $table->integer('branch_id');
            $table->integer('user_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_shoppings_shopping', function($table)
        {
            $table->dropColumn('branch_id');
            $table->dropColumn('user_id');
        });
    }
}
