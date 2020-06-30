<?php namespace AppShopping\Orders\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteAppshoppingOrdersOrdersItems extends Migration
{
    public function up()
    {
        Schema::dropIfExists('appshopping_orders_orders_items');
    }
    
    public function down()
    {
        Schema::create('appshopping_orders_orders_items', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('product_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->time('details');
            $table->primary(['product_id','order_id']);
        });
    }
}
