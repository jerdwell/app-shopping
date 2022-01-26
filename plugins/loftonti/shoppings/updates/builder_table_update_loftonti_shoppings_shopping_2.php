<?php namespace LoftonTi\Shoppings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiShoppingsShopping2 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_shoppings_shopping', function($table)
        {
            $table->string('notes')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_shoppings_shopping', function($table)
        {
            $table->dropColumn('notes');
        });
    }
}
