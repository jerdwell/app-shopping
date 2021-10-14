<?php namespace LoftonTi\Shoppings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiShoppingsShoppingContact extends Migration
{
    public function up()
    {
        Schema::table('loftonti_shoppings_shopping_contact', function($table)
        {
            $table->increments('id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_shoppings_shopping_contact', function($table)
        {
            $table->dropColumn('id');
        });
    }
}
