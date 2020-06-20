<?php namespace appShopping\Orders\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppshoppingOrdersOrdersItems extends Migration
{
    public function up()
    {
        Schema::rename('appshopping_orders_order_items', 'appshopping_orders_orders_items');
    }
    
    public function down()
    {
        Schema::rename('appshopping_orders_orders_items', 'appshopping_orders_order_items');
    }
}
