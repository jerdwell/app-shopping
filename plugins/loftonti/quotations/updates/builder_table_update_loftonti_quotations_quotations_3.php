<?php namespace LoftonTi\Quotations\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateLoftontiQuotationsQuotations3 extends Migration
{
    public function up()
    {
        Schema::table('loftonti_quotations_quotations', function($table)
        {
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('status', 191)->default('active')->change();
            $table->text('shipping_address')->default(null)->change();
            $table->dateTime('shipping_date')->default(null)->change();
            $table->text('shipping_contact')->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('loftonti_quotations_quotations', function($table)
        {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
            $table->string('status', 191)->default('\'active\'')->change();
            $table->text('shipping_address')->default('NULL')->change();
            $table->dateTime('shipping_date')->default('NULL')->change();
            $table->text('shipping_contact')->default('NULL')->change();
        });
    }
}
