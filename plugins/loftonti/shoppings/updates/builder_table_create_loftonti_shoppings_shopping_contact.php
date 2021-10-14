<?php namespace LoftonTi\Shoppings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiShoppingsShoppingContact extends Migration
{
    public function up()
    {
        Schema::create('loftonti_shoppings_shopping_contact', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('shopping_id')->unsigned();
            $table->string('address1');
            $table->string('suburb');
            $table->string('zip_code');
            $table->string('state');
            $table->string('city');
            $table->string('country');
            $table->string('fullname');
            $table->string('email');
            $table->string('phone');
            $table->string('address2');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_shoppings_shopping_contact');
    }
}
