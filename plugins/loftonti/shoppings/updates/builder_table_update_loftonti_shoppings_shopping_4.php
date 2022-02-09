<?php namespace LoftonTi\Shoppings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiShoppingsShopping4 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_shoppings_shopping', function($table)
        {
            $table->string('case_shopping')->default('bar');
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_shoppings_shopping', function($table)
        {
            $table->dropColumn('case_shopping');
        });
    }
}
