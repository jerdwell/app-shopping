<?php namespace AppShopping\Orders\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppshoppingOrdersOrdersItems12 extends Migration
{
    public function up()
    {
        Schema::table('appshopping_orders_orders_items', function($table)
        {
            $table->time('details');
            $table->dropColumn('quantity');
            $table->dropColumn('brand_code');
        });
    }
    
    public function down()
    {
        Schema::table('appshopping_orders_orders_items', function($table)
        {
            $table->dropColumn('details');
            $table->integer('quantity');
            $table->string('brand_code', 191);
        });
    }
}
