<?php namespace appshopping\Customers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAppshoppingCustomersCustomers extends Migration
{
    public function up()
    {
        Schema::create('appshopping_customers_customers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('customer_name', 150);
            $table->string('customer_lastname', 150);
            $table->string('customer_email', 100);
            $table->string('customer_phone', 100);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('customer_password', 150);
            $table->boolean('customer_email_verified')->default(false);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('appshopping_customers_customers');
    }
}
