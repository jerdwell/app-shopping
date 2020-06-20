<?php namespace appShopping\Orders\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppshoppingOrdersOrders2 extends Migration
{
    public function up()
    {
        Schema::table('appshopping_orders_orders', function($table)
        {
            $table->string('order_code', 150);
            $table->renameColumn('status', 'order_status');
            $table->renameColumn('valid', 'order_valid');
        });
    }
    
    public function down()
    {
        Schema::table('appshopping_orders_orders', function($table)
        {
            $table->dropColumn('order_code');
            $table->renameColumn('order_status', 'status');
            $table->renameColumn('order_valid', 'valid');
        });
    }
}
