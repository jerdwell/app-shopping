<?php namespace LoftonTi\Quotations\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateLoftontiQuotationsQuotations extends Migration
{
    public function up()
    {
        Schema::create('loftonti_quotations_quotations', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->text('items');
            $table->double('amount', 10, 0);
            $table->string('status')->default('active');
            $table->text('shipping_address')->nullable();
            $table->dateTime('shipping_date')->nullable();
            $table->text('shipping_contact')->nullable();
            $table->integer('branch')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loftonti_quotations_quotations');
    }
}
