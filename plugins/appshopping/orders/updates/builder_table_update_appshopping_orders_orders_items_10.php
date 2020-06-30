<?php namespace AppShopping\Orders\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppshoppingOrdersOrdersItems10 extends Migration
{
    public function up()
    {
        Schema::table('appshopping_orders_orders_items', function($table)
        {
            $table->integer('product_brand')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::table('appshopping_orders_orders_items', function($table)
        {
            $table->dropColumn('product_brand');
        });
    }
}
