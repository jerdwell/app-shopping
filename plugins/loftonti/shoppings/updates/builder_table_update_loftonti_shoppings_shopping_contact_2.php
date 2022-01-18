<?php namespace LoftonTi\Shoppings\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiShoppingsShoppingContact2 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_shoppings_shopping_contact', function($table)
        {
            $table->string('address1', 191)->nullable()->change();
            $table->string('suburb', 191)->nullable()->change();
            $table->string('zip_code', 191)->nullable()->change();
            $table->string('state', 191)->nullable()->change();
            $table->string('city', 191)->nullable()->change();
            $table->string('country', 191)->nullable()->change();
            $table->string('fullname', 191)->nullable()->change();
            $table->string('email', 191)->nullable()->change();
            $table->string('phone', 191)->nullable()->change();
            $table->string('address2', 191)->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_shoppings_shopping_contact', function($table)
        {
            $table->string('address1', 191)->nullable(false)->change();
            $table->string('suburb', 191)->nullable(false)->change();
            $table->string('zip_code', 191)->nullable(false)->change();
            $table->string('state', 191)->nullable(false)->change();
            $table->string('city', 191)->nullable(false)->change();
            $table->string('country', 191)->nullable(false)->change();
            $table->string('fullname', 191)->nullable(false)->change();
            $table->string('email', 191)->nullable(false)->change();
            $table->string('phone', 191)->nullable(false)->change();
            $table->string('address2', 191)->nullable(false)->change();
        });
    }
}
