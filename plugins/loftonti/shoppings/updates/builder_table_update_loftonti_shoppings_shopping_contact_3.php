<?php namespace LoftonTi\Shoppings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiShoppingsShoppingContact3 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_shoppings_shopping_contact', function($table)
        {
            $table->string('rfc')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_shoppings_shopping_contact', function($table)
        {
            $table->dropColumn('rfc');
        });
    }
}
