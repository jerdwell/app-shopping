<?php namespace appShopping\Orders\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppshoppingOrdersOrdersItems4 extends Migration
{
    public function up()
    {
        Schema::table('appshopping_orders_orders_items', function($table)
        {
            $table->integer('product_id')->unsigned()->change();
            $table->integer('order_id')->unsigned()->change();
        });
    }
    
    public function down()
    {
        Schema::table('appshopping_orders_orders_items', function($table)
        {
            $table->integer('product_id')->unsigned(false)->change();
            $table->integer('order_id')->unsigned(false)->change();
        });
    }
}
