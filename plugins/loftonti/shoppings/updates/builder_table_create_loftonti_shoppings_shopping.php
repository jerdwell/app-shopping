<?php namespace LoftonTi\Shoppings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiShoppingsShopping extends Migration
{
    public function up()
    {
        Schema::create('loftonti_shoppings_shopping', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->decimal('amount', 12, 2)->default(0.00);
            $table->decimal('discount', 12, 2)->default(0.00);
            $table->string('status')->default('standby');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->decimal('shipping_cost', 12, 2)->default(0.00);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_shoppings_shopping');
    }
}
