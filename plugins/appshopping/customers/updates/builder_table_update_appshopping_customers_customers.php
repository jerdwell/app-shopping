<?php namespace appshopping\Customers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppshoppingCustomersCustomers extends Migration
{
    public function up()
    {
        Schema::table('appshopping_customers_customers', function($table)
        {
            $table->text('address')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('appshopping_customers_customers', function($table)
        {
            $table->dropColumn('address');
        });
    }
}
