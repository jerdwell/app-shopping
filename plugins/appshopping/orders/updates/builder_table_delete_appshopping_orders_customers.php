<?php namespace AppShopping\Orders\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteAppshoppingOrdersCustomers extends Migration
{
    public function up()
    {
        Schema::dropIfExists('appshopping_orders_customers');
    }
    
    public function down()
    {
        Schema::create('appshopping_orders_customers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('customer_id');
            $table->integer('order_id');
            $table->primary(['customer_id','order_id']);
        });
    }
}
