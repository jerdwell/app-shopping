<?php namespace appshopping\Customers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppshoppingCustomersCustomers2 extends Migration
{
    public function up()
    {
        Schema::table('appshopping_customers_customers', function($table)
        {
            $table->renameColumn('address', 'customer_address');
        });
    }
    
    public function down()
    {
        Schema::table('appshopping_customers_customers', function($table)
        {
            $table->renameColumn('customer_address', 'address');
        });
    }
}
