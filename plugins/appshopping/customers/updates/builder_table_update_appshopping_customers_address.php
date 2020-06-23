<?php namespace appshopping\Customers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppshoppingCustomersAddress extends Migration
{
    public function up()
    {
        Schema::rename('appshopping_customers_', 'appshopping_customers_address');
    }
    
    public function down()
    {
        Schema::rename('appshopping_customers_address', 'appshopping_customers_');
    }
}
