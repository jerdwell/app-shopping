<?php namespace AppShopping\Orders\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppshoppingOrdersOrders6 extends Migration
{
    public function up()
    {
        Schema::table('appshopping_orders_orders', function($table)
        {
            $table->integer('order_total')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('appshopping_orders_orders', function($table)
        {
            $table->dropColumn('order_total');
        });
    }
}
