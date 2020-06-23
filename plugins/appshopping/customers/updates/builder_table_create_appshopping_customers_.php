<?php namespace appshopping\Customers\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateAppshoppingCustomers extends Migration
{
    public function up()
    {
        Schema::create('appshopping_customers_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('address', 100);
            $table->double('lat', 10, 6);
            $table->double('lng', 10, 6);
            $table->string('country', 100);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('appshopping_customers_');
    }
}
