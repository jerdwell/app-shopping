<?php namespace appshopping\Customers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteAppshoppingCustomersCustomerAddress extends Migration
{
    public function up()
    {
        Schema::dropIfExists('appshopping_customers_customer_address');
    }
    
    public function down()
    {
        Schema::create('appshopping_customers_customer_address', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('address', 100);
            $table->double('lat', 10, 6);
            $table->double('lng', 10, 6);
            $table->string('country', 100);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('customer_id');
        });
    }
}
