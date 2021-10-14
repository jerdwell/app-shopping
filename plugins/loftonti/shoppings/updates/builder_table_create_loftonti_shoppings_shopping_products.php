<?php namespace LoftonTi\Shoppings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiShoppingsShoppingProducts extends Migration
{
    public function up()
    {
        Schema::create('loftonti_shoppings_shopping_products', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('shopping_id');
            $table->integer('product_id');
            $table->decimal('current_price', 12, 2)->default(0.00);
            $table->decimal('discount', 12, 2)->default(0.00);
            $table->integer('quantity')->default(0);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_shoppings_shopping_products');
    }
}
