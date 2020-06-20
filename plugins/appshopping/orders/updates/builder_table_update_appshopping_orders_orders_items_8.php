<?php namespace AppShopping\Orders\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppshoppingOrdersOrdersItems8 extends Migration
{
    public function up()
    {
        Schema::table('appshopping_orders_orders_items', function($table)
        {
            $table->increments('id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('appshopping_orders_orders_items', function($table)
        {
            $table->dropColumn('id');
        });
    }
}
