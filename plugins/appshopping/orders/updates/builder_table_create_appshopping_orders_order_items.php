<?php namespace appShopping\Orders\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAppshoppingOrdersOrderItems extends Migration
{
    public function up()
    {
        Schema::create('appshopping_orders_order_items', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('product_id');
            $table->integer('order_id');
            $table->primary(['product_id','order_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('appshopping_orders_order_items');
    }
}
