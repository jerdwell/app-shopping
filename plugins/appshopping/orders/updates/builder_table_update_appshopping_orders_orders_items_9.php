<?php namespace AppShopping\Orders\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppshoppingOrdersOrdersItems9 extends Migration
{
    public function up()
    {
        Schema::table('appshopping_orders_orders_items', function($table)
        {
            $table->dropColumn('id');
            $table->primary(['product_id','order_id']);
        });
    }
    
    public function down()
    {
        Schema::table('appshopping_orders_orders_items', function($table)
        {
            $table->dropPrimary(['product_id','order_id']);
            $table->increments('id')->unsigned();
        });
    }
}
