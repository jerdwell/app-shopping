<?php namespace LoftonTi\Shoppings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiShoppingsShoppingProducts extends Migration
{
    public function up()
    {
        Schema::table('loftonti_shoppings_shopping_products', function($table)
        {
            $table->integer('shopping_id')->unsigned()->change();
            $table->integer('product_id')->unsigned()->change();
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_shoppings_shopping_products', function($table)
        {
            $table->integer('shopping_id')->unsigned(false)->change();
            $table->integer('product_id')->unsigned(false)->change();
        });
    }
}
