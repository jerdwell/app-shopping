<?php namespace LoftonTi\Shoppings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiShoppingsShopping3 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_shoppings_shopping', function($table)
        {
            $table->boolean('sold_out')->default(false);
            $table->string('payment_method')->default('cash');
            $table->string('type_billing')->default('receipt');
            $table->string('billing_id')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_shoppings_shopping', function($table)
        {
            $table->dropColumn('sold_out');
            $table->dropColumn('payment_method');
            $table->dropColumn('type_billing');
            $table->dropColumn('billing_id');
        });
    }
}
