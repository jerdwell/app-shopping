<?php namespace AppShopping\Orders\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateAppshoppingOrdersOrdersItems11 extends Migration
{
    public function up()
    {
        Schema::table('appshopping_orders_orders_items', function($table)
        {
            $table->string('brand_code');
            $table->dropColumn('product_brand');
        });
    }
    
    public function down()
    {
        Schema::table('appshopping_orders_orders_items', function($table)
        {
            $table->dropColumn('brand_code');
            $table->integer('product_brand')->unsigned();
        });
    }
}
