<?php namespace AppShopping\Orders\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAppshoppingOrdersCustomers extends Migration
{
    public function up()
    {
        Schema::create('appshopping_orders_customers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('customer_id');
            $table->integer('order_id');
            $table->primary(['customer_id','order_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('appshopping_orders_customers');
    }
}
