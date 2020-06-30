<?php namespace AppShopping\Orders\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppshoppingOrdersOrders8 extends Migration
{
    public function up()
    {
        Schema::table('appshopping_orders_orders', function($table)
        {
            $table->renameColumn('details', 'order_details');
        });
    }
    
    public function down()
    {
        Schema::table('appshopping_orders_orders', function($table)
        {
            $table->renameColumn('order_details', 'details');
        });
    }
}
