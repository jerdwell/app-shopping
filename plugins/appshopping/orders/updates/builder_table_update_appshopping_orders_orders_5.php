<?php namespace AppShopping\Orders\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppshoppingOrdersOrders5 extends Migration
{
    public function up()
    {
        Schema::table('appshopping_orders_orders', function($table)
        {
            $table->integer('customer_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('appshopping_orders_orders', function($table)
        {
            $table->integer('customer_id')->nullable(false)->change();
        });
    }
}
