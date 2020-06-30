<?php namespace AppShopping\Orders\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppshoppingOrdersOrders7 extends Migration
{
    public function up()
    {
        Schema::table('appshopping_orders_orders', function($table)
        {
            $table->text('details');
        });
    }
    
    public function down()
    {
        Schema::table('appshopping_orders_orders', function($table)
        {
            $table->dropColumn('details');
        });
    }
}
