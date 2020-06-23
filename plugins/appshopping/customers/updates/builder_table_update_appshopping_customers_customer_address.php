<?php namespace appshopping\Customers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppshoppingCustomersCustomerAddress extends Migration
{
    public function up()
    {
        Schema::rename('appshopping_customers_address', 'appshopping_customers_customer_address');
        Schema::table('appshopping_customers_customer_address', function($table)
        {
            $table->integer('customer_id');
        });
    }
    
    public function down()
    {
        Schema::rename('appshopping_customers_customer_address', 'appshopping_customers_address');
        Schema::table('appshopping_customers_address', function($table)
        {
            $table->dropColumn('customer_id');
        });
    }
}
